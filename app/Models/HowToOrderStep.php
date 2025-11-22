<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowToOrderStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'content_id',
        'content_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk hanya mengambil step yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
