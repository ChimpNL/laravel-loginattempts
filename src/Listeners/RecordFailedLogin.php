<?php

namespace LamaLama\LoginAttempts\Listeners;

use LamaLama\LoginAttempts\Events\AuthFailed;
use LamaLama\LoginAttempts\Models\LoginAttempt;

class RecordFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AuthFailed $event
     *
     * @return void
     */
    public function handle(AuthFailed $event)
    {
        if (! config('login-attempts.record_failed_login')) {
            return;
        }

        LoginAttempt::create([
            'event'   => 'failed',
            'user_id' => null,
            'email'   => $event->user->email,
            'ip'      => request()->ip(),
        ]);
    }
}
