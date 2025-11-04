<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'first_level_percentage',
        'second_level_percentage',
        'buyer_percentage',
        'is_active',
    ];

    protected $casts = [
        'first_level_percentage' => 'decimal:2',
        'second_level_percentage' => 'decimal:2',
        'buyer_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the product this commission is for
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Create or update commission for a product
     */
    public static function setForProduct(
        Product $product,
        float $firstLevelPercentage,
        float $secondLevelPercentage,
        float $buyerPercentage
    ): self {
        return self::updateOrCreate(
            ['product_id' => $product->id],
            [
                'first_level_percentage' => $firstLevelPercentage,
                'second_level_percentage' => $secondLevelPercentage,
                'buyer_percentage' => $buyerPercentage,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get commission for a product
     */
    public static function getForProduct(Product $product): ?self
    {
        return self::where('product_id', $product->id)
                   ->where('is_active', true)
                   ->first();
    }

    /**
     * Calculate commission amount for a given order item
     */
    public function calculateCommission(float $orderItemTotal, int $level): float
    {
        $percentage = match ($level) {
            0 => $this->buyer_percentage,
            1 => $this->first_level_percentage,
            2 => $this->second_level_percentage,
            default => 0,
        };

        return ($orderItemTotal * $percentage) / 100;
    }

    /**
     * Get total commission percentage (all levels + buyer)
     */
    public function getTotalPercentage(): float
    {
        return $this->first_level_percentage + 
               $this->second_level_percentage + 
               $this->buyer_percentage;
    }

    /**
     * Check if commission is valid (total should not exceed 100%)
     */
    public function isValid(): bool
    {
        return $this->getTotalPercentage() <= 100;
    }
}