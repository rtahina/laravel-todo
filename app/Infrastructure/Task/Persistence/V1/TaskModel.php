<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TaskModel extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['user_id', 'title', 'is_completed', 'created_at'];

    public $timestamps = false;

    protected function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
