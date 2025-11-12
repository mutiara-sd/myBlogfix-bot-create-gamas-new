<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code', 
        'description',
        'owner_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('owner_id', $userId);
    }

    // ✅ Method archive dan activate yang dipanggil di controller
    public function archive(): bool
    {
        return $this->update(['status' => 'archived']);
    }

    public function activate(): bool
    {
        return $this->update(['status' => 'active']);
    }

    // Generate unique project code
    public static function generateUniqueCode(string $name): string
    {
        $baseCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3));
        $counter = 1;
        $code = $baseCode . sprintf('%03d', $counter);

        while (self::where('code', $code)->exists()) {
            $counter++;
            $code = $baseCode . sprintf('%03d', $counter);
        }

        return $code;
    }
}