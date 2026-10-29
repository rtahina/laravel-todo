<?php

declare(strict_types=1);

namespace App\Domains\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function save(User $user): User;

    /**
     * @return User[]
     */
    public function all(): array;

    public function delete(int $id): mixed;
}
