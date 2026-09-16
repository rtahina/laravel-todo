<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\V1;

use App\Domain\Task\V1\Task;
use App\Domain\Task\V1\TaskRepositoryInterface;

final class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(private readonly TaskMapper $mapper) {}

    public function save(Task $task): TaskModel
    {
        $task = TaskModel::query()->updateOrCreate(
            ['id' => $task->id()],
            $this->mapper->toAttributes($task),
        );

        return $task;
    }

    public function findById(int $id): ?Task
    {
        $model = TaskModel::query()->find($id);

        return $model !== null ? $this->mapper->toDomain($model) : null;
    }

    public function all(): array
    {
        return TaskModel::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (TaskModel $model) => $this->mapper->toDomain($model))
            ->all();
    }

    public function delete(int $id): int
    {
        return TaskModel::query()->where('id', $id)->delete();
    }
}
