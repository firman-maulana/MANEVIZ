<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'tax',
        'total',
        'total_amount',
        'shipping_cost',
        'grand_total',
        'courier_code',
        'courier_service',
        'shipping_district_id',
        'total_weight',
        'payment_method',
        'payment_status',
        'transaction_id',
        'snap_token',
        'payment_type',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
        'billing_name',
        'billing_phone',
        'billing_email',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_postal_code',
        'notes',
        'order_date',
        'shipped_date',
        'delivered_date',
        'address_id',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'delivered_date' => 'datetime',
    ];

    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');

        $lastOrder = self::where('order_number', 'like', $prefix . $date . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Diterima',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
        ];

        return $labels[$this->payment_status] ?? 'Unknown';
    }

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'credit_card' => 'Kartu Kredit',
            'ewallet' => 'E-Wallet',
            'cod' => 'Cash on Delivery (COD)',
            'midtrans' => 'Midtrans Payment Gateway',
        ];

        return $labels[$this->payment_method] ?? 'Unknown';
    }

    public function getCourierLabelAttribute()
    {
        $couriers = [
            'jne' => 'JNE',
            'tiki' => 'TIKI',
            'pos' => 'POS Indonesia',
            'jnt' => 'J&T Express',
            'sicepat' => 'SiCepat',
            'anteraja' => 'AnterAja',
        ];

        return $couriers[$this->courier_code] ?? strtoupper($this->courier_code);
    }

    public function getFullShippingAddressAttribute()
    {
        return $this->shipping_address . ', ' . $this->shipping_city . ', ' . $this->shipping_province . ' ' . $this->shipping_postal_code;
    }

    public function getFullBillingAddressAttribute()
    {
        return $this->billing_address . ', ' . $this->billing_city . ', ' . $this->billing_province . ' ' . $this->billing_postal_code;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['delivered', 'cancelled']);
    }

    public function scopeHistory($query)
    {
        return $query->whereIn('status', ['delivered', 'cancelled']);
    }

    public function isMidtransPayment()
    {
        return in_array($this->payment_method, ['bank_transfer', 'credit_card', 'ewallet']) && $this->payment_type === 'midtrans';
    }

    public function needsPayment()
    {
        return $this->payment_status === 'pending' && $this->payment_method !== 'cod';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hasUnreviewedItems()
    {
        return $this->status === 'delivered' &&
            $this->orderItems()->whereDoesntHave('review')->exists();
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function isCompleted()
    {
        return in_array($this->status, ['delivered', 'cancelled']);
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'status-pending',
            'processing' => 'status-processing',
            'shipped' => 'status-shipped',
            'delivered' => 'status-delivered',
            'cancelled' => 'status-cancelled',
        ];

        return $classes[$this->status] ?? 'status-unknown';
    }
}