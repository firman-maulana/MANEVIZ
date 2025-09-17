<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        // 'phone', // Dihapus - menggunakan phone dari user
        'address',
        'city',
        'province',
        'postal_code',
        'notes',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    /**
     * Get phone number from user relationship.
     */
    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    /**
     * Get full address string.
     */
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->province . ' ' . $this->postal_code;
    }

    /**
     * Scope for default address.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Set this address as default and unset others.
     */
    public function setAsDefault()
    {
        // Unset all other default addresses for this user
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this address as default
        $this->update(['is_default' => true]);
    }
}