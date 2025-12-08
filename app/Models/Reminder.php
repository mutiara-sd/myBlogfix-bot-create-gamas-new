<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'remindable_id',
        'remindable_type',
        'user_id',
        'remind_at',
        'notify_telegram',
        'notify_email',
        'note',
        'is_sent',
        'sent_at',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'sent_at' => 'datetime',
        'notify_telegram' => 'boolean',
        'notify_email' => 'boolean',
        'is_sent' => 'boolean',
    ];

    // Polymorphic relationship
    public function remindable()
    {
        return $this->morphTo();
    }

    // User yang membuat reminder
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk reminder yang belum terkirim
    public function scopePending($query)
    {
        return $query->where('is_sent', false)
                    ->where('remind_at', '<=', now());
    }

    // Scope untuk reminder yang akan datang
    public function scopeUpcoming($query)
    {
        return $query->where('is_sent', false)
                    ->where('remind_at', '>', now())
                    ->orderBy('remind_at');
    }
}