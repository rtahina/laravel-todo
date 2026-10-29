<?php

declare(strict_types=1);

namespace App\Infrastructures\Task\Persistence;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * User
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $title
 * @property-read bool $is_completed
 * @property-read string $created_at
 */
final class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['user_id', 'title', 'is_completed', 'created_at'];

    public $timestamps = false;

    /**
     * @return BelongsTo<User, $this>
     */
    protected function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include current user's tasks.
     *
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopeMine(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include completed tasks.
     *
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope a query to only include on going tasks.
     *
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopeOnGoing(Builder $query): Builder
    {
        return $query->where('is_completed', false);
    }
}
