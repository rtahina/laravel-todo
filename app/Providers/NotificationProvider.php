<?php

namespace App\Providers;

use App\Domains\Task\TaskNotificationInterface;
use App\Infrastructures\Task\Notifications\PusherNotification;
use Illuminate\Support\ServiceProvider;

class NotificationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskNotificationInterface::class, PusherNotification::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
