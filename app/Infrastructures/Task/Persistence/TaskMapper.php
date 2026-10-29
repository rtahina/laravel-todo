<?php

declare(strict_types=1);

namespace App\Infrastructures\Task\Persistence;

use App\Domains\Task\Task;
use App\Infrastructures\Task\Persistence\Task as TaskModel;
use DateTimeImmutable;

final class TaskMapper
{
    public function toDomain(TaskModel $model): Task
    {
        return Task::reconstitute(
            id: $model->id,
            userId: $model->user_id,
            title: $model->title,
            isComplete: (bool) $model->is_completed,
            createdAt: new DateTimeImmutable($model->created_at)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toAttributes(Task $task): array
    {
        return [
            'id' => $task->id(),
            'user_id' => $task->userId(),
            'title' => $task->title(),
            'is_completed' => $task->isCompleted(),
            'created_at' => $task->createdAt()->format('Y-m-d H:i:s'),
        ];
    }
}
