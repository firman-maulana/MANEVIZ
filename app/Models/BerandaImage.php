<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BerandaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'image_path',
        'title',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk mendapatkan carousel images
    public function scopeCarousel($query)
    {
        return $query->where('type', 'carousel')
                     ->where('is_active', true)
                     ->orderBy('order');
    }

    // Scope untuk mendapatkan banner image
    public function scopeBanner($query)
    {
        return $query->where('type', 'banner')
                     ->where('is_active', true)
                     ->first();
    }

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    // Event ketika model dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Hapus file dari storage
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        });
    }
}
