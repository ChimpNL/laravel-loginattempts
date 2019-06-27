<?php

namespace Chimp\LoginAttempts;

use Illuminate\Support\ServiceProvider;
use Chimp\LoginAttempts\LoginAttempts;

class LoginAttemptsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('login-attempts', function () {
            return new LoginAttempts();
        });
    }
}
