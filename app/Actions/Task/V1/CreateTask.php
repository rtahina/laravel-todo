<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Actions\Task\V1\DTO\TaskData;
use App\Actions\User\DTO\UserData;
use App\Domain\Task\V1\Task;
use App\Domain\Task\V1\TaskRepositoryInterface;

final class CreateTask
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(string $title, UserData $user): TaskData
    {
        $task = Task::create($user->id, $title);
        $taskDomain = $this->repository->save($task);

        return TaskData::fromEntity($taskDomain);
    }
}
