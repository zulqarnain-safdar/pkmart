<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the user's referral codes
     */
    public function referralCodes()
    {
        return $this->hasMany(ReferralCode::class);
    }

    /**
     * Get the user's active referral code
     */
    public function activeReferralCode()
    {
        return $this->hasOne(ReferralCode::class)->where('is_active', true);
    }

    /**
     * Get relationships where this user is the referrer
     */
    public function referrals()
    {
        return $this->hasMany(ReferralRelationship::class, 'referrer_id');
    }

    /**
     * Get relationships where this user was referred
     */
    public function referrer()
    {
        return $this->hasOne(ReferralRelationship::class, 'referred_id');
    }

    /**
     * Get the user's referral earnings
     */
    public function referralEarnings()
    {
        return $this->hasMany(ReferralEarning::class);
    }

    /**
     * Get the user's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get or create active referral code for this user
     */
    public function getOrCreateReferralCode(): ReferralCode
    {
        return ReferralCode::getOrCreateForUser($this);
    }

    /**
     * Get total referral earnings
     */
    public function getTotalReferralEarnings(): float
    {
        return ReferralEarning::getTotalForUser($this);
    }

    /**
     * Get pending referral earnings
     */
    public function getPendingReferralEarnings()
    {
        return ReferralEarning::getPendingForUser($this);
    }
}
