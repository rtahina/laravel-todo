<?php

declare(strict_types=1);

namespace App\Domains\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): Task;

    public function findById(int $id): ?Task;

    /**
     * @param  array<string, mixed>  $args
     * @return Task[]
     */
    public function all(array $args): array;

    public function delete(int $id): mixed;
}
