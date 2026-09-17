<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\User as UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly UserMapper $mapper) {}

    public function save(UserEntity $user): UserEntity
    {
        $userModel = User::query()->updateOrCreate(
            ['id' => $user->id()],
            $this->mapper->toAttributes($user),
        );

        return $this->mapper->toDomain($userModel);
    }

    public function findById(int $id): ?UserEntity
    {
        $model = User::query()->find($id);

        return $model !== null ? $this->mapper->toDomain($model) : null;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $model = User::query()->where('email', '=', $email)->get();
        $model = $model[0] ?? null; // email is unique in db

        return $model !== null ? $this->mapper->toDomain($model) : null;
    }

    public function all(): array
    {
        return User::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (User $model) => $this->mapper->toDomain($model))
            ->all();
    }

    public function delete(int $id): int
    {
        return User::query()->where('id', $id)->delete();
    }
}
