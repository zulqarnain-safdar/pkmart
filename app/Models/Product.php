<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'image',
        'gallery',
        'category_id',
        'is_featured',
        'is_active',
        'has_referral_commission',
        'referral_commission_percentage',
        'buyer_commission_percentage',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'has_referral_commission' => 'boolean',
        'referral_commission_percentage' => 'decimal:2',
        'buyer_commission_percentage' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Get the commission settings for this product
     */
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }

    /**
     * Get or create commission settings for this product
     */
    public function getCommission(): ?Commission
    {
        return Commission::getForProduct($this);
    }

    /**
     * Set commission settings for this product
     */
    public function setCommission(float $firstLevel, float $secondLevel, float $buyer): Commission
    {
        return Commission::setForProduct($this, $firstLevel, $secondLevel, $buyer);
    }
}
