<?php

declare(strict_types=1);

namespace App\Actions\Task\V1;

use App\Domain\Task\V1\Exceptions\TaskNotFoundException;
use App\Domain\Task\V1\TaskRepositoryInterface;

final class DeleteTask
{
    public function __construct(private readonly TaskRepositoryInterface $repository) {}

    public function handle(int $id): void
    {
        $deletedRow = $this->repository->delete($id);

        if ($deletedRow === 0) {
            throw TaskNotFoundException::withId($id);
        }
    }
}
