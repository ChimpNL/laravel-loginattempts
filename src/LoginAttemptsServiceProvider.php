<?php

namespace LamaLama\LoginAttempts;

use Illuminate\Support\ServiceProvider;
use LamaLama\LoginAttempts\Console\Commands\ClearLoginAttempts;
use LamaLama\LoginAttempts\Console\Commands\ClearFailedLoginAttempts;
use LamaLama\LoginAttempts\Console\Commands\ClearSucceededLoginAttempts;

class LoginAttemptsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPublishables();
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearLoginAttempts::class,
                ClearFailedLoginAttempts::class,
                ClearSucceededLoginAttempts::class,
            ]);
        }
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/login-attempts.php' => config_path('login-attempts.php'),
        ], 'config');

        if (! class_exists('CreateWishlistTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_login_attempts_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_login_attempts_table.php'),
            ], 'migrations');
        }
    }
}
