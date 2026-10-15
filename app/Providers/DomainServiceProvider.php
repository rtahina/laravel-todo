<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domains\Task\TaskRepositoryInterface;
use App\Domains\User\UserRepositoryInterface;
use App\Infrastructures\Task\Persistence\TaskRepository;
use App\Infrastructures\User\Persistence\UserRepository;
use Illuminate\Support\ServiceProvider;

final class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
