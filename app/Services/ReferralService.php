<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReferralCode;
use App\Models\ReferralRelationship;
use App\Models\ReferralEarning;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    /**
     * Process referral when a new user registers with a referral code
     */
    public function processReferral(string $referralCode, User $newUser): bool
    {
        try {
            DB::beginTransaction();

            // Find the referral code
            $code = ReferralCode::where('code', $referralCode)
                                ->where('is_active', true)
                                ->first();

            if (!$code || !$code->isValid()) {
                DB::rollBack();
                return false;
            }

            $referrer = $code->user;

            // Check if user is already referred
            $existingRelationship = ReferralRelationship::where('referred_id', $newUser->id)->first();
            if ($existingRelationship) {
                DB::rollBack();
                return false;
            }

            // Create referral relationship (level 1)
            ReferralRelationship::createRelationship($referrer, $newUser, $code, 1);

            // Create second level relationship if referrer has a referrer
            $referrerRelationship = ReferralRelationship::where('referred_id', $referrer->id)
                                                       ->where('level', 1)
                                                       ->where('is_active', true)
                                                       ->first();

            if ($referrerRelationship) {
                $secondLevelReferrer = $referrerRelationship->referrer;
                ReferralRelationship::createRelationship($secondLevelReferrer, $newUser, $code, 2);
            }

            // Mark referral code as used
            $code->markAsUsed();

            // Create referral code for the new user
            ReferralCode::createForUser($newUser);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Referral processing failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Process commissions when an order is completed
     */
    public function processOrderCommissions(Order $order): bool
    {
        try {
            DB::beginTransaction();

            $totalCommissionAmount = 0;

            foreach ($order->items as $item) {
                $product = $item->product;
                $commission = Commission::getForProduct($product);

                if (!$commission || !$commission->is_active) {
                    continue;
                }

                $itemTotal = $item->price * $item->quantity;

                // Get referral chain for the buyer
                $referralChain = ReferralRelationship::getReferralChain($order->user);

                // Process commissions for each level
                foreach ($referralChain as $index => $referrer) {
                    $level = $index + 1;
                    $commissionAmount = $commission->calculateCommission($itemTotal, $level);

                    if ($commissionAmount > 0) {
                        // Create referral earning
                        ReferralEarning::createEarning(
                            $referrer,
                            $order,
                            $product,
                            $commissionAmount,
                            $level === 1 ? $commission->first_level_percentage : $commission->second_level_percentage,
                            'referral',
                            null, // No specific referral code for this earning
                            $level
                        );

                        $totalCommissionAmount += $commissionAmount;
                    }
                }

                // Process buyer commission if applicable
                $buyerCommissionAmount = $commission->calculateCommission($itemTotal, 0);
                if ($buyerCommissionAmount > 0) {
                    ReferralEarning::createEarning(
                        $order->user,
                        $order,
                        $product,
                        $buyerCommissionAmount,
                        $commission->buyer_percentage,
                        'buyer'
                    );

                    $totalCommissionAmount += $buyerCommissionAmount;
                }
            }

            // Update order with total commission amount
            $order->update([
                'total_commission_amount' => $totalCommissionAmount,
                'commissions_processed' => true,
                'commissions_processed_at' => now(),
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Commission processing failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Renew referral code for a user
     */
    public function renewReferralCode(User $user): ?ReferralCode
    {
        try {
            $referralCode = ReferralCode::getActiveForUser($user);

            if ($referralCode) {
                $referralCode->renew();
                return $referralCode;
            }

            // Create new referral code if none exists
            return ReferralCode::createForUser($user);

        } catch (\Exception $e) {
            Log::error('Referral code renewal failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get referral statistics for a user
     */
    public function getReferralStats(User $user): array
    {
        $referrals = ReferralRelationship::getActiveForReferrer($user);
        
        return [
            'total_referrals' => $referrals->count(),
            'direct_referrals' => $referrals->where('level', 1)->count(),
            'second_level_referrals' => $referrals->where('level', 2)->count(),
            'total_earnings' => $user->getTotalReferralEarnings(),
            'pending_earnings' => $user->getPendingReferralEarnings()->sum('amount'),
            'active_referral_code' => $user->getOrCreateReferralCode(),
        ];
    }

    /**
     * Validate referral code
     */
    public function validateReferralCode(string $code): array
    {
        $referralCode = ReferralCode::where('code', $code)->first();

        if (!$referralCode) {
            return ['valid' => false, 'message' => 'Invalid referral code'];
        }

        if (!$referralCode->isValid()) {
            return ['valid' => false, 'message' => 'Referral code has expired'];
        }

        return [
            'valid' => true,
            'code' => $referralCode,
            'referrer' => $referralCode->user,
            'message' => 'Valid referral code'
        ];
    }

    /**
     * Get user's referral earnings history
     */
    public function getEarningsHistory(User $user, int $limit = 50): array
    {
        $earnings = ReferralEarning::getHistoryForUser($user, $limit);
        
        return [
            'total_earnings' => $user->getTotalReferralEarnings(),
            'pending_earnings' => $user->getPendingReferralEarnings()->sum('amount'),
            'history' => $earnings,
            'stats' => [
                'total_referral_earnings' => $earnings->where('type', 'referral')->sum('amount'),
                'total_buyer_earnings' => $earnings->where('type', 'buyer')->sum('amount'),
                'paid_earnings' => $earnings->where('status', 'paid')->sum('amount'),
                'pending_earnings' => $earnings->where('status', 'pending')->sum('amount'),
            ]
        ];
    }

    /**
     * Process monthly referral code renewal for all users
     */
    public function processMonthlyRenewals(): int
    {
        $expiredCodes = ReferralCode::where('is_active', true)
                                   ->where('expires_at', '<', now())
                                   ->get();

        $renewedCount = 0;

        foreach ($expiredCodes as $code) {
            // Deactivate expired code
            $code->update(['is_active' => false]);
            
            // Create new code for user if they have made a purchase in the last month
            $user = $code->user;
            $hasRecentOrder = $user->orders()
                                  ->where('created_at', '>=', now()->subMonth())
                                  ->where('payment_status', 'paid')
                                  ->exists();

            if ($hasRecentOrder) {
                ReferralCode::createForUser($user);
                $renewedCount++;
            }
        }

        return $renewedCount;
    }
}
