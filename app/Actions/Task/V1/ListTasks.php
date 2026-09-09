<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Actions\Task\V1\DTO\TaskData;
use App\Domain\Task\V1\TaskRepositoryInterface;

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
