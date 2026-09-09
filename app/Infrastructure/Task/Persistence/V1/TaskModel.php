<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\V1;

use Illuminate\Database\Eloquent\Model;

final class TaskModel extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['title', 'is_completed', 'created_at'];

    public $timestamps = false;
}
