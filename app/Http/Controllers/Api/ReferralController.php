<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Get user's referral code and statistics
     */
    public function getMyReferralCode()
    {
        $user = Auth::user();
        $referralCode = $user->getOrCreateReferralCode();
        $stats = $this->referralService->getReferralStats($user);

        return response()->json([
            'success' => true,
            'data' => [
                'referral_code' => $referralCode,
                'stats' => $stats,
            ]
        ]);
    }

    /**
     * Validate a referral code
     */
    public function validateReferralCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->referralService->validateReferralCode($request->code);

        return response()->json([
            'success' => $result['valid'],
            'message' => $result['message'],
            'data' => $result['valid'] ? [
                'code' => $result['code'],
                'referrer_name' => $result['referrer']->name,
            ] : null
        ]);
    }

    /**
     * Get referral earnings history
     */
    public function getEarningsHistory(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 50);
        
        $earnings = $this->referralService->getEarningsHistory($user, $limit);

        return response()->json([
            'success' => true,
            'data' => $earnings
        ]);
    }

    /**
     * Get referral statistics
     */
    public function getReferralStats()
    {
        $user = Auth::user();
        $stats = $this->referralService->getReferralStats($user);

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Renew referral code
     */
    public function renewReferralCode()
    {
        $user = Auth::user();
        $referralCode = $this->referralService->renewReferralCode($user);

        if (!$referralCode) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to renew referral code'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Referral code renewed successfully',
            'data' => $referralCode
        ]);
    }

    /**
     * Get referral tree (referrals and their referrals)
     */
    public function getReferralTree()
    {
        $user = Auth::user();
        $referrals = $user->referrals()->with(['referred', 'referralCode'])->get();

        $tree = $referrals->map(function ($referral) {
            $referredUser = $referral->referred;
            $secondLevelReferrals = $referredUser->referrals()->with('referred')->get();

            return [
                'user' => [
                    'id' => $referredUser->id,
                    'name' => $referredUser->name,
                    'email' => $referredUser->email,
                    'joined_at' => $referral->created_at,
                ],
                'referral_code' => $referral->referralCode->code,
                'level' => $referral->level,
                'second_level_referrals' => $secondLevelReferrals->map(function ($secondReferral) {
                    return [
                        'user' => [
                            'id' => $secondReferral->referred->id,
                            'name' => $secondReferral->referred->name,
                            'email' => $secondReferral->referred->email,
                            'joined_at' => $secondReferral->created_at,
                        ],
                        'level' => $secondReferral->level,
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $tree
        ]);
    }
}