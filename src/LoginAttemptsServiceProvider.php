<?php

namespace Chimp\LoginAttempts;

use Illuminate\Support\ServiceProvider;
use Chimp\LoginAttempts\LoginAttempts;

class LoginAttemptsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->app->bind('login-attempts', function () {
            return new LoginAttempts();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearLoginAttempts::class,
            ]);
        }
    }
}
