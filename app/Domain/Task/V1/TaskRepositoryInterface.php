<?php

declare(strict_types=1);

namespace App\Domain\Task\V1;

interface TaskRepositoryInterface
{
    public function save(Task $task): Task;

    public function findById(int $id): ?Task;

    /**
     * @return Task[]
     */
    public function all(): array;

    public function delete(int $id): int;
}
