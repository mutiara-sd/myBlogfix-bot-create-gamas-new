<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'minute_id',
        'title',
        'description',
        'assignee_id',
        'priority',
        'status',
        'due_date',
        'progress_percent',
        'weight',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label', 'task_id', 'label_id');
    }

    public function progressUpdates()
    {
    return $this->hasMany(ProgressUpdate::class);
    }

    public function comments()
    {
    return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id');
    }

    public function attachments()
    {
    return $this->hasMany(Attachment::class);
    }
    
    public function minute()
    {
    return $this->hasMany(Minute::class);
    }
    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'remindable')->orderBy('remind_at');
    }
}