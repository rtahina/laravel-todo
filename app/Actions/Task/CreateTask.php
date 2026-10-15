<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Task\DTO\TaskData;
use App\Domains\Task\Task;
use App\Domains\Task\TaskRepositoryInterface;

final class CreateTask
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(TaskData $taskData): TaskData
    {
        $task = Task::create($taskData);
        $taskDomain = $this->repository->save($task);

        return TaskData::fromEntity($taskDomain);
    }
}
