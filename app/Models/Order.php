<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'tax_amount',
        'shipping_amount',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'shipping_address',
        'billing_address',
        'phone',
        'notes',
        'referral_code_used',
        'referrer_id',
        'total_commission_amount',
        'commissions_processed',
        'commissions_processed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_commission_amount' => 'decimal:2',
        'commissions_processed' => 'boolean',
        'commissions_processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user who referred this order
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get referral earnings from this order
     */
    public function referralEarnings(): HasMany
    {
        return $this->hasMany(ReferralEarning::class);
    }

    /**
     * Mark commissions as processed
     */
    public function markCommissionsProcessed(): void
    {
        $this->update([
            'commissions_processed' => true,
            'commissions_processed_at' => now(),
        ]);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }
}
