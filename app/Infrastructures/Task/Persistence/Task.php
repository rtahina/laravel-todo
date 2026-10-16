<?php

declare(strict_types=1);

namespace App\Infrastructures\Task\Persistence;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['user_id', 'title', 'is_completed', 'created_at'];

    public $timestamps = false;

    protected function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include current user's tasks.
     */
    protected function scopeMine(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include completed tasks.
     */
    protected function scopeCompleted(Builder $query): void
    {
        $query->where('is_completed', true);
    }

    /**
     * Scope a query to only include on going tasks.
     */
    protected function scopeOnGoing(Builder $query): void
    {
        $query->where('is_completed', false);
    }
}
