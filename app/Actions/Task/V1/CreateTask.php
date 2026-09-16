<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Actions\Task\V1\DTO\TaskData;
use App\Domain\Task\V1\Task;
use App\Domain\Task\V1\TaskRepositoryInterface;
use App\Infrastructure\Task\Persistence\V1\TaskMapper;

final class CreateTask
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(string $title): TaskData
    {
        $task = Task::create($title);
        $taskDomain = $this->repository->save($task);
        
        return TaskData::fromEntity($taskDomain);
    }
}
