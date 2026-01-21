<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'paragraph_1',
        'paragraph_2',
        'paragraph_3',
        'paragraph_4',
        'paragraph_5',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Boot method untuk memastikan hanya 1 yang aktif
    protected static function booted()
    {
        static::creating(function ($aboutContent) {
            if ($aboutContent->is_active) {
                static::where('is_active', true)->update(['is_active' => false]);
            }
        });

        static::updating(function ($aboutContent) {
            if ($aboutContent->is_active) {
                static::where('id', '!=', $aboutContent->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
        });
    }

    // Scope untuk mendapatkan konten aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
