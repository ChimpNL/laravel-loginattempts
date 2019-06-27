<?php

namespace Chimp\LoginAttempts\Facades;

use Illuminate\Support\Facades\Facade;

class LoginAttempts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'login-attempts';
    }
}
