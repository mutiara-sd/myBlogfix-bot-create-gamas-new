<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'scheduled_at',
        'location',
        'organizer_id',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function agendas()
    {
    return $this->hasMany(Agenda::class, 'meeting_id')->orderBy('id', 'asc');
    }

    public function minuteDecisions()
    {
    return $this->hasMany(MinuteDecision::class, 'meeting_id')->orderBy('id', 'asc');
    }

}