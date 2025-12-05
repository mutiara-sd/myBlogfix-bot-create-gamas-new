<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'body',
        'attachment_path',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Polymorphic relationship - Get the parent commentable model (Task or Meeting)
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who created the comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if comment has attachment
     */
    public function hasAttachment(): bool
    {
        return !is_null($this->attachment_path);
    }

    /**
     * Get attachment file name
     */
    public function getAttachmentNameAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }

        return basename($this->attachment_path);
    }

    /**
     * Get attachment file size in human readable format
     */
    public function getAttachmentSizeHumanAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }

        $filePath = storage_path('app/public/' . $this->attachment_path);

        if (!file_exists($filePath)) {
            return null;
        }

        $bytes = filesize($filePath);

        if ($bytes === 0) return '0 Bytes';

        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));

        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Get attachment icon based on file extension
     */
    public function getAttachmentIconAttribute(): string
    {
        if (!$this->attachment_path) {
            return 'fa-file';
        }

        $extension = strtolower(pathinfo($this->attachment_path, PATHINFO_EXTENSION));

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

    /**
     * Get attachment URL
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }

        return asset('storage/' . $this->attachment_path);
    }

    /**
     * Scope to get recent comments
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope to get comments by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}