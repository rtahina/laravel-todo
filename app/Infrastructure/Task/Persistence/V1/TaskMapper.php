<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\V1;

use App\Domain\Task\V1\Task;
use DateTimeImmutable;

final class TaskMapper
{
    public function toDomain(TaskModel $model): Task
    {
        return Task::reconstitute(
            id: $model->id,
            title: $model->title,
            isComplete: (bool) $model->is_completed,
            createdAt: new DateTimeImmutable($model->created_at)
        );
    }

    public function toAttributes(Task $task): array
    {
        return [
            'id' => $task->id(),
            'title' => $task->title(),
            'is_completed' => $task->isCompleted(),
            'created_at' => $task->createdAt()->format('Y-m-d H:i:s'),
        ];
    }
}
