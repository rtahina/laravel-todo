<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Task\V1\TaskRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Task\Persistence\V1\TaskRepository;
use App\Infrastructure\User\Persistence\UserRepository;
use Illuminate\Support\ServiceProvider;

final class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
