<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\DTO\UserData;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

final class CreateUser
{
    public function __construct(private readonly UserRepositoryInterface $repository) {}

    public function handle(UserData $user): UserData
    {
        $user = User::create($user->name, $user->email, $user->password);
        $userEntity = $this->repository->save($user);

        return UserData::fromEntity($userEntity);
    }
}
