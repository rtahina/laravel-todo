<?php

declare(strict_types=1);

namespace App\Domain\Task\V1;

use App\Infrastructure\Task\Persistence\V1\TaskModel;

interface TaskRepositoryInterface
{
    public function save(Task $task): TaskModel;

    public function findById(int $id): ?Task;

    /**
     * @return Task[]
     */
    public function all(): array;

    public function delete(int $id): int;
}
