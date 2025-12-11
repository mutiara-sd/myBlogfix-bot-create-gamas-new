<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressUpdate extends Model
{
    protected $fillable = [
        'task_id',
        'created_by',
        'percent',
        'note',
        'is_blocked',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'percent' => 'integer',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::created(function ($progressUpdate) {
            $task = $progressUpdate->task;
            
            // ✅ Hitung total dari semua updates (SUM)
            $totalProgress = $task->progressUpdates()->sum('percent');
            $task->progress_percent = min($totalProgress, 100);
            
            // ✅ JANGAN UPDATE STATUS! Biar user aja yang manual
            // Komentar semua auto status update
            /*
            if ($task->status === 'todo' && $task->progress_percent > 0) {
                $task->status = 'doing';
            }
            
            if ($task->progress_percent >= 100) {
                $task->status = 'done';
            }
            
            if ($progressUpdate->is_blocked) {
                $task->status = 'blocked';
            }
            */
            
            $task->save();
        });

        static::deleted(function ($progressUpdate) {
            $task = $progressUpdate->task;
            
            // Recalculate setelah delete
            $totalProgress = $task->progressUpdates()->sum('percent');
            $task->progress_percent = min($totalProgress, 100);
            
            $task->save();
        });
    }
}