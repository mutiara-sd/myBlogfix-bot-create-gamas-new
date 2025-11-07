<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks'; // biar jelas, walaupun defaultnya sama

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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label', 'task_id', 'label_id');
    }
}