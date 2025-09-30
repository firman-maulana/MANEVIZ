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
    ];

    protected $casts = [
        'dimensi' => 'array',
        'meta_data' => 'array',
        'is_featured' => 'boolean',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke semua gambar produk
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

    // Relasi ke gambar utama produk
    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id')->where('is_primary', true);
    }

    // 🔥 REVIEW RELATIONSHIPS - Tambahkan ini
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 🔥 REVIEW METHODS - Tambahkan semua method ini
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

    // 🔥 METHOD BARU - Rating breakdown dengan persentase
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

    // 🔥 METHOD BARU - Persentase rekomendasi
    public function getRecommendationPercentage()
    {
        $totalReviews = $this->reviews()->count();

        if ($totalReviews === 0) {
            return 0;
        }

        $recommendedCount = $this->reviews()->where('is_recommended', true)->count();

        return round(($recommendedCount / $totalReviews) * 100);
    }

    // 🔥 METHOD BARU - Update rating rata-rata (panggil ini setiap ada review baru/update/delete)
    public function updateAverageRating()
    {
        $this->rating_rata = $this->averageRating();
        $this->total_reviews = $this->totalReviews();
        $this->save();
    }

    // Scope untuk hanya ambil produk aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // 🔥 SCOPE BARU - Untuk featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // 🔥 ACCESSOR BARU - Format harga dengan mata uang
    public function getFormattedPriceAttribute()
    {
        return 'IDR ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFormattedSalePriceAttribute()
    {
        return 'IDR ' . number_format($this->harga_jual, 0, ',', '.');
    }

    // 🔥 ACCESSOR BARU - Cek apakah sedang sale
    public function getIsOnSaleAttribute()
    {
        return $this->harga_jual && $this->harga_jual < $this->harga;
    }

    // 🔥 ACCESSOR BARU - Harga final (sale atau normal)
    public function getFinalPriceAttribute()
    {
        return $this->harga_jual ?: $this->harga;
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
}
