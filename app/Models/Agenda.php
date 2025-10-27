<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'agenda_text'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}