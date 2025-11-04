<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'is_active',
        'expires_at',
        'last_used_at',
        'usage_count',
        'total_earnings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'total_earnings' => 'decimal:2',
    ];

    /**
     * Generate a unique referral code for the user
     */
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Create a referral code for a user
     */
    public static function createForUser(User $user): self
    {
        return self::create([
            'user_id' => $user->id,
            'code' => self::generateCode(),
            'is_active' => true,
            'expires_at' => now()->addMonth(), // Expires in 1 month
        ]);
    }

    /**
     * Check if the referral code is valid and active
     */
    public function isValid(): bool
    {
        return $this->is_active && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Renew the referral code for another month
     */
    public function renew(): void
    {
        $this->update([
            'expires_at' => now()->addMonth(),
            'is_active' => true,
        ]);
    }

    /**
     * Mark as used and update usage count
     */
    public function markAsUsed(): void
    {
        $this->update([
            'last_used_at' => now(),
            'usage_count' => $this->usage_count + 1,
        ]);
    }

    /**
     * Get the user who owns this referral code
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all relationships where this code was used
     */
    public function relationships(): HasMany
    {
        return $this->hasMany(ReferralRelationship::class);
    }

    /**
     * Get all earnings from this referral code
     */
    public function earnings(): HasMany
    {
        return $this->hasMany(ReferralEarning::class);
    }

    /**
     * Get active referral code for a user
     */
    public static function getActiveForUser(User $user): ?self
    {
        return self::where('user_id', $user->id)
                   ->where('is_active', true)
                   ->where(function ($query) {
                       $query->whereNull('expires_at')
                             ->orWhere('expires_at', '>', now());
                   })
                   ->first();
    }

    /**
     * Get or create active referral code for a user
     */
    public static function getOrCreateForUser(User $user): self
    {
        $code = self::getActiveForUser($user);
        
        if (!$code) {
            $code = self::createForUser($user);
        }
        
        return $code;
    }
}