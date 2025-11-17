<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImages;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'deskripsi',
        'deskripsi_singkat',
        'harga',
        'harga_jual',
        'sku',
        'stock_kuantitas',
        'berat',
        'dimensi',
        'ukuran',
        'status',
        'is_featured',
        'rating_rata',
        'total_reviews',
        'total_penjualan',
        'meta_data',

        // 🔥 Tambahan diskon
        'discount_percentage',
        'discount_start_date',
        'discount_end_date',
    ];

    protected $casts = [
        'dimensi' => 'array',
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id')->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function ratingDistribution()
    {
        return $this->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')
            ->toArray();
    }

    public function getRatingBreakdown()
    {
        $distribution = $this->ratingDistribution();
        $total = $this->totalReviews();

        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $distribution[$i] ?? 0;
            $percentage = $total > 0 ? ($count / $total) * 100 : 0;

            $breakdown[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 1)
            ];
        }

        return $breakdown;
    }

    public function getRecommendationPercentage()
    {
        $totalReviews = $this->reviews()->count();

        if ($totalReviews === 0) {
            return 0;
        }

        $recommendedCount = $this->reviews()->where('is_recommended', true)->count();

        return round(($recommendedCount / $totalReviews) * 100);
    }

    public function updateAverageRating()
    {
        $this->rating_rata = $this->averageRating();
        $this->total_reviews = $this->totalReviews();
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFormattedPriceAttribute()
    {
        return 'IDR ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFormattedSalePriceAttribute()
    {
        return 'IDR ' . number_format($this->harga_jual, 0, ',', '.');
    }

    public function getWeightInGrams()
    {
        $weight = $this->berat ?? 1000;

        if ($weight > 0 && $weight < 100) {
            $weight = $weight * 1000;
        }

        return (int) $weight;
    }

    public function getFormattedWeightAttribute()
    {
        $grams = $this->getWeightInGrams();

        if ($grams >= 1000) {
            return number_format($grams / 1000, 2, ',', '.') . ' kg';
        }

        return number_format($grams, 0, ',', '.') . ' g';
    }


    // ============================================================
    // 🔥 DISCOUNT METHODS
    // ============================================================

    public function hasActiveDiscount()
    {
        if (!$this->discount_percentage || $this->discount_percentage <= 0) {
            return false;
        }

        $now = now();

        if (!$this->discount_start_date && !$this->discount_end_date) {
            return true;
        }

        if ($this->discount_start_date && $now < $this->discount_start_date) {
            return false;
        }

        if ($this->discount_end_date && $now > $this->discount_end_date) {
            return false;
        }

        return true;
    }

    public function getDiscountedPrice()
    {
        if (!$this->hasActiveDiscount()) {
            return $this->harga_jual ?: $this->harga;
        }

        $basePrice = $this->harga_jual ?: $this->harga;
        $discountAmount = ($basePrice * $this->discount_percentage) / 100;

        return $basePrice - $discountAmount;
    }

    public function getDiscountAmount()
    {
        if (!$this->hasActiveDiscount()) {
            return 0;
        }

        $basePrice = $this->harga_jual ?: $this->harga;

        return ($basePrice * $this->discount_percentage) / 100;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->hasActiveDiscount()) {
            return $this->getDiscountedPrice();
        }

        return $this->harga_jual ?: $this->harga;
    }

    public function getOriginalPrice()
    {
        return $this->harga_jual ?: $this->harga;
    }

    public function getIsOnSaleAttribute()
    {
        return ($this->harga_jual && $this->harga_jual < $this->harga)
            || $this->hasActiveDiscount();
    }

    public function getFormattedFinalPriceAttribute()
    {
        return 'IDR ' . number_format($this->final_price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return 'IDR ' . number_format($this->getOriginalPrice(), 0, ',', '.');
    }

    public function getDiscountLabel()
    {
        if (!$this->hasActiveDiscount()) {
            return null;
        }

        return '-' . number_format($this->discount_percentage, 0) . '%';
    }

    public function scopeWithActiveDiscount($query)
    {
        return $query->where('discount_percentage', '>', 0)
            ->where(function ($q) {
                $q->whereNull('discount_start_date')
                  ->orWhere('discount_start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('discount_end_date')
                  ->orWhere('discount_end_date', '>=', now());
            });
    }
}
