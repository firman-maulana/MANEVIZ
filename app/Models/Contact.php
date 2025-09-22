<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'subject',
        'message',
        'status',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Subject options
    public static function getSubjectOptions(): array
    {
        return [
            'general' => 'General Inquiry',
            'support' => 'Customer Support',
            'sales' => 'Sales Question',
            'partnership' => 'Partnership',
            'other' => 'Other',
        ];
    }

    // Status options
    public static function getStatusOptions(): array
    {
        return [
            'new' => 'New',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ];
    }

    // Status colors for UI
    public static function getStatusColors(): array
    {
        return [
            'new' => 'primary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'closed' => 'gray',
        ];
    }

    // Get subject label
    public function getSubjectLabelAttribute(): string
    {
        return self::getSubjectOptions()[$this->subject] ?? $this->subject;
    }

    // Get status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    // Get status color
    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'gray';
    }

    // Mark as read
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    // Check if unread
    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    // Scopes
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeBySubject(Builder $query, string $subject): Builder
    {
        return $query->where('subject', $subject);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}