<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralRelationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code_id',
        'level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    /**
     * Get the user who made the referral
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who was referred
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Get the referral code used
     */
    public function referralCode(): BelongsTo
    {
        return $this->belongsTo(ReferralCode::class);
    }

    /**
     * Create a referral relationship
     */
    public static function createRelationship(
        User $referrer,
        User $referred,
        ReferralCode $referralCode,
        int $level = 1
    ): self {
        return self::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $referred->id,
            'referral_code_id' => $referralCode->id,
            'level' => $level,
            'is_active' => true,
        ]);
    }

    /**
     * Get all active relationships for a referrer
     */
    public static function getActiveForReferrer(User $referrer): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('referrer_id', $referrer->id)
                   ->where('is_active', true)
                   ->with(['referred', 'referralCode'])
                   ->get();
    }

    /**
     * Get referral chain for a user (up to 2 levels)
     */
    public static function getReferralChain(User $user): array
    {
        $chain = [];
        
        // Get direct referrer (level 1)
        $directReferrer = self::where('referred_id', $user->id)
                             ->where('level', 1)
                             ->where('is_active', true)
                             ->with('referrer')
                             ->first();
        
        if ($directReferrer) {
            $chain[] = $directReferrer->referrer;
            
            // Get second level referrer (level 2)
            $secondLevelReferrer = self::where('referred_id', $directReferrer->referrer_id)
                                     ->where('level', 1)
                                     ->where('is_active', true)
                                     ->with('referrer')
                                     ->first();
            
            if ($secondLevelReferrer) {
                $chain[] = $secondLevelReferrer->referrer;
            }
        }
        
        return $chain;
    }
}