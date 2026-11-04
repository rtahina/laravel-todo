<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pusher\Pusher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Pusher::class, fn () => new Pusher(
            (string) config('pusher.key', ''),
            (string) config('pusher.secret', ''),
            (string) config('pusher.app_id', ''),
            ['cluster' => config('pusher.cluster', '')],
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
