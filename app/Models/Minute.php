<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'summary',
        'decisions',
        'risks',
        'status'
    ];

    // Relationships
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function attendees()
    {
        return $this->hasMany(MinuteAttendee::class);
    }
}

// app/Models/MinuteAttendee.php