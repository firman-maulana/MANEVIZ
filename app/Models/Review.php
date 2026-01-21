<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'order_item_id',
        'rating',
        'review',
        'images',
        'is_verified',
        'is_recommended',
    ];

    protected $casts = [
        'images' => 'array',
        'is_verified' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // Accessors
    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    // 🔥 NEW: Censor username - show only initials
    public function getCensoredNameAttribute()
    {
        if (!$this->user) {
            return 'Anonymous';
        }

        $name = $this->user->name;
        $words = explode(' ', $name);

        if (count($words) === 1) {
            // Single word name: show first letter + asterisks
            // Example: "John" -> "J***"
            return strtoupper(substr($name, 0, 1)) . str_repeat('*', min(3, strlen($name) - 1));
        } else {
            // Multiple words: show first letter of each word
            // Example: "John Doe" -> "J*** D***"
            $censored = [];
            foreach ($words as $word) {
                if (strlen($word) > 0) {
                    $censored[] = strtoupper(substr($word, 0, 1)) . str_repeat('*', min(3, strlen($word) - 1));
                }
            }
            return implode(' ', $censored);
        }
    }

    // 🔥 NEW: Get initials for avatar
    public function getReviewerInitialsAttribute()
    {
        if (!$this->user) {
            return 'A';
        }

        $name = $this->user->name;
        $words = explode(' ', $name);

        if (count($words) === 1) {
            // Single word: first letter only
            return strtoupper(substr($name, 0, 1));
        } else {
            // Multiple words: first letter of first and last word
            $firstInitial = strtoupper(substr($words[0], 0, 1));
            $lastInitial = strtoupper(substr($words[count($words) - 1], 0, 1));
            return $firstInitial . $lastInitial;
        }
    }

    // SCOPES - Pastikan ini ada
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeWithImages($query)
    {
        return $query->whereNotNull('images');
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeLowestRated($query)
    {
        return $query->orderBy('rating', 'asc');
    }
}
