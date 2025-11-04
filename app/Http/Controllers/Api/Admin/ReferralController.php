<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Product;
use App\Models\ReferralCode;
use App\Models\ReferralEarning;
use App\Models\ReferralRelationship;
use App\Models\User;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Get all referral codes with statistics
     */
    public function getReferralCodes(Request $request)
    {
        $query = ReferralCode::with(['user'])
                            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('code', 'like', "%{$search}%");
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                      ->where(function ($q) {
                          $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                      });
            } elseif ($request->status === 'expired') {
                $query->where(function ($q) {
                    $q->where('is_active', false)
                      ->orWhere('expires_at', '<=', now());
                });
            }
        }

        $referralCodes = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $referralCodes
        ]);
    }

    /**
     * Get all referral relationships
     */
    public function getReferralRelationships(Request $request)
    {
        $query = ReferralRelationship::with(['referrer', 'referred', 'referralCode'])
                                   ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('referrer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('referred', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        $relationships = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $relationships
        ]);
    }

    /**
     * Get all referral earnings
     */
    public function getReferralEarnings(Request $request)
    {
        $query = ReferralEarning::with(['user', 'order', 'product', 'referralCode'])
                               ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $earnings = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $earnings
        ]);
    }

    /**
     * Set commission for a product
     */
    public function setProductCommission(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'first_level_percentage' => 'required|numeric|min:0|max:100',
            'second_level_percentage' => 'required|numeric|min:0|max:100',
            'buyer_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $totalPercentage = $request->first_level_percentage + 
                          $request->second_level_percentage + 
                          $request->buyer_percentage;

        if ($totalPercentage > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total commission percentage cannot exceed 100%'
            ], 422);
        }

        $commission = Commission::setForProduct(
            $product,
            $request->first_level_percentage,
            $request->second_level_percentage,
            $request->buyer_percentage
        );

        return response()->json([
            'success' => true,
            'message' => 'Commission set successfully',
            'data' => $commission
        ]);
    }

    /**
     * Get commission for a product
     */
    public function getProductCommission(Product $product)
    {
        $commission = Commission::getForProduct($product);

        return response()->json([
            'success' => true,
            'data' => $commission
        ]);
    }

    /**
     * Mark referral earning as paid
     */
    public function markEarningAsPaid(ReferralEarning $earning)
    {
        $earning->markAsPaid();

        return response()->json([
            'success' => true,
            'message' => 'Earning marked as paid'
        ]);
    }

    /**
     * Mark referral earning as cancelled
     */
    public function markEarningAsCancelled(ReferralEarning $earning)
    {
        $earning->markAsCancelled();

        return response()->json([
            'success' => true,
            'message' => 'Earning marked as cancelled'
        ]);
    }

    /**
     * Process monthly renewals
     */
    public function processMonthlyRenewals()
    {
        $renewedCount = $this->referralService->processMonthlyRenewals();

        return response()->json([
            'success' => true,
            'message' => "Processed {$renewedCount} referral code renewals",
            'data' => ['renewed_count' => $renewedCount]
        ]);
    }

    /**
     * Get referral system statistics
     */
    public function getReferralStats()
    {
        $stats = [
            'total_referral_codes' => ReferralCode::count(),
            'active_referral_codes' => ReferralCode::where('is_active', true)->count(),
            'expired_referral_codes' => ReferralCode::where('is_active', false)->count(),
            'total_referral_relationships' => ReferralRelationship::count(),
            'active_referral_relationships' => ReferralRelationship::where('is_active', true)->count(),
            'total_referral_earnings' => ReferralEarning::sum('amount'),
            'paid_referral_earnings' => ReferralEarning::where('status', 'paid')->sum('amount'),
            'pending_referral_earnings' => ReferralEarning::where('status', 'pending')->sum('amount'),
            'total_commissions' => Commission::count(),
            'active_commissions' => Commission::where('is_active', true)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Deactivate a referral code
     */
    public function deactivateReferralCode(ReferralCode $referralCode)
    {
        $referralCode->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Referral code deactivated'
        ]);
    }

    /**
     * Reactivate a referral code
     */
    public function reactivateReferralCode(ReferralCode $referralCode)
    {
        $referralCode->update([
            'is_active' => true,
            'expires_at' => now()->addMonth()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Referral code reactivated'
        ]);
    }
}