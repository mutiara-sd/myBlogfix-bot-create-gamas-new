<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MeetingComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'user_id',
        'comment_text',
        'attachment_path',      
        'attachment_name', 
        'attachment_size', 
    ];

    protected $with = ['user'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getAttachmentSizeHumanAttribute()
    {
        if (!$this->attachment_size) return null;
        
        $bytes = $this->attachment_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getAttachmentIconAttribute()
    {
        if (!$this->attachment_name) return null;
        
        $extension = pathinfo($this->attachment_name, PATHINFO_EXTENSION);
        
        $icons = [
            'pdf' => 'fa-file-pdf text-danger',
            'doc' => 'fa-file-word text-primary',
            'docx' => 'fa-file-word text-primary',
            'xls' => 'fa-file-excel text-success',
            'xlsx' => 'fa-file-excel text-success',
            'ppt' => 'fa-file-powerpoint text-warning',
            'pptx' => 'fa-file-powerpoint text-warning',
            'jpg' => 'fa-file-image text-info',
            'jpeg' => 'fa-file-image text-info',
            'png' => 'fa-file-image text-info',
            'gif' => 'fa-file-image text-info',
            'zip' => 'fa-file-archive text-secondary',
            'rar' => 'fa-file-archive text-secondary',
            'txt' => 'fa-file-alt text-muted',
        ];

        return $icons[strtolower($extension)] ?? 'fa-file text-muted';
    }

    protected static function booted()
    {
        static::deleting(function ($comment) {
            if ($comment->attachment_path && Storage::disk('public')->exists($comment->attachment_path)) {
                Storage::disk('public')->delete($comment->attachment_path);
            }
        });
    }
}