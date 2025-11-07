<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'user_id',
        'role',
        'present'
    ];

    protected $casts = [
        'present' => 'boolean'
    ];

    // Relationships
    public function minute()
    {
        return $this->belongsTo(Minute::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}