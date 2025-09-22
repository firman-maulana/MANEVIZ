<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'order_id',
        'total_transfer',
        'transfer_to',
        'account_holder',
        'notes',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'total_transfer' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user who verified this payment confirmation
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get formatted total transfer
     */
    public function getFormattedTotalTransferAttribute(): string
    {
        return 'Rp ' . number_format($this->total_transfer, 0, ',', '.');
    }

    /**
     * Get bank name from transfer_to field
     */
    public function getBankNameAttribute(): string
    {
        $banks = [
            'bca-449-008-1777' => 'BCA 449-008-1777 a/n Anggullo Agrisbo',
            'mandiri' => 'Bank Mandiri',
            'bni' => 'Bank BNI',
            'bri' => 'Bank BRI',
        ];

        return $banks[$this->transfer_to] ?? $this->transfer_to;
    }

    /**
     * Get status color for display
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default => ucfirst($this->status)
        };
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for recent submissions
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}