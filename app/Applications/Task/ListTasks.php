<?php

declare(strict_types=1);

namespace App\Applications\Task;

use App\Applications\Task\DTO\TaskData;
use App\Domains\Task\TaskRepositoryInterface;

final class ListTasks
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    /**
     * @param  array<string, mixed>  $args
     * @return TaskData[]
     */
    public function handle(array $args): array
    {
        return array_map(
            static fn ($task) => TaskData::fromEntity($task),
            $this->repository->all($args),
        );
    }
}
