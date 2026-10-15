<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Task\DTO\TaskData;
use App\Domains\Task\TaskRepositoryInterface;

final class ListTasks
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(): array
    {
        return array_map(
            static fn ($task) => TaskData::fromEntity($task),
            $this->repository->all(),
        );
    }
}
