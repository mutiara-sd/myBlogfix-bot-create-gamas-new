<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteDecision extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'decision_text',
        'status',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}