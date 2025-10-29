<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'risk_title',
        'mitigation',
        'owner',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}