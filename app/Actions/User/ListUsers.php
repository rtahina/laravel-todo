<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\DTO\UserData;
use App\Domains\User\UserRepositoryInterface;

final class ListUsers
{
    public function __construct(private readonly UserRepositoryInterface $repository) {}

    public function handle(): array
    {
        return array_map(
            static fn ($user) => UserData::fromEntity($user),
            $this->repository->all(),
        );
    }
}
