<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'name',
        'path',
        'mime',
        'size',
    ];

    /**
     * Task relationship
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    /**
     * Get filename (alias untuk name)
     */
    public function getFilenameAttribute()
    {
        return $this->name;
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute()
    {
        if (!$this->size) return null;

        $bytes = $this->size;
        if ($bytes === 0) return '0 Bytes';

        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));

        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Get file icon based on extension
     */
    public function getFileIconAttribute()
    {
        $extension = strtolower(pathinfo($this->name, PATHINFO_EXTENSION));

        return match($extension) {
            'pdf' => 'fa-file-pdf text-danger',
            'doc', 'docx' => 'fa-file-word text-primary',
            'xls', 'xlsx' => 'fa-file-excel text-success',
            'ppt', 'pptx' => 'fa-file-powerpoint text-warning',
            'jpg', 'jpeg', 'png', 'gif', 'svg' => 'fa-file-image text-info',
            'zip', 'rar', '7z' => 'fa-file-archive text-secondary',
            'txt' => 'fa-file-alt text-muted',
            default => 'fa-file text-muted',
        };
    }
}