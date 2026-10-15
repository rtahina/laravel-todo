<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Actions\Task\V1\DTO\TaskData;
use App\Domains\Task\V1\Task;
use App\Domains\Task\V1\TaskRepositoryInterface;

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
