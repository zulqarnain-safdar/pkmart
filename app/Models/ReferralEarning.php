<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'referral_code_id',
        'level',
        'amount',
        'percentage',
        'type',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the user who earned this commission
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order this earning is from
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product this earning is from
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the referral code used
     */
    public function referralCode(): BelongsTo
    {
        return $this->belongsTo(ReferralCode::class);
    }

    /**
     * Create a referral earning record
     */
    public static function createEarning(
        User $user,
        Order $order,
        Product $product,
        float $amount,
        float $percentage,
        string $type,
        ?ReferralCode $referralCode = null,
        int $level = 0
    ): self {
        return self::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'referral_code_id' => $referralCode?->id,
            'level' => $level,
            'amount' => $amount,
            'percentage' => $percentage,
            'type' => $type,
            'status' => 'pending',
        ]);
    }

    /**
     * Mark earning as paid
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark earning as cancelled
     */
    public function markAsCancelled(): void
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Get total earnings for a user
     */
    public static function getTotalForUser(User $user, string $status = 'paid'): float
    {
        return self::where('user_id', $user->id)
                   ->where('status', $status)
                   ->sum('amount');
    }

    /**
     * Get pending earnings for a user
     */
    public static function getPendingForUser(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('user_id', $user->id)
                   ->where('status', 'pending')
                   ->with(['order', 'product', 'referralCode'])
                   ->get();
    }

    /**
     * Get earnings history for a user
     */
    public static function getHistoryForUser(User $user, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('user_id', $user->id)
                   ->with(['order', 'product', 'referralCode'])
                   ->orderBy('created_at', 'desc')
                   ->limit($limit)
                   ->get();
    }
}