<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;

final class DeleteUser
{
    public function __construct(private readonly UserRepositoryInterface $repository) {}

    public function handle(int $id): void
    {
        $deletedRow = $this->repository->delete($id);

        if ($deletedRow === 0) {
            throw new UserNotFoundException;
        }
    }
}
