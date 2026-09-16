<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Actions\Task\V1\DTO\TaskData;
use App\Domain\Task\V1\Exceptions\TaskNotFoundException;
use App\Domain\Task\V1\TaskRepositoryInterface;

final class ToggleTaskStatus
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(int $id): TaskData
    {
        $task = $this->repository->findById($id);
        if (is_null($task)) {
            throw TaskNotFoundException::withId($id);
        }
        $toggledTask = $task::toggleStatus($task);
        $this->repository->save($toggledTask);

        return TaskData::fromEntity($toggledTask);
    }
}
