<?php

declare(strict_types=1);

namespace App\Actions\User\DTO;

use App\Domain\User\User as UserEntity;
use App\Models\User;

final class UserData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email
    ) {}

    public static function fromEntity(UserEntity $user): self
    {
        return new self(
            id: $user->id(),
            name: $user->name(),
            email: $user->email()
        );
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }
}
