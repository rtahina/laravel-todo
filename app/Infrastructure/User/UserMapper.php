<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\User;
use App\Models\User as UserModel;

final class UserMapper
{
    public function toDomain(UserModel $model): User
    {
        return User::reconstitute(
            id: $model->id,
            name: $model->name,
            email: $model->email
        );
    }

    public function toAttributes(User $user): array
    {
        return [
            'id' => $user->id(),
            'name' => $user->name(),
            'email' => $user->email(),
        ];
    }
}
