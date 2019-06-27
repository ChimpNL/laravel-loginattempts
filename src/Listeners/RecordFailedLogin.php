<?php

namespace App\Listeners;

use App\Events\AuthFailed;
use App\Models\LoginAttempt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordFailedLoginAttempt
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
     * @param  AuthFailed  $event
     * @return void
     */
    public function handle(AuthFailed $event)
    {
        LoginAttempt::create([
            'event' => 'failed',
            'user_id' => null,
            'email' => $event->user->email,
            'ip' => request()->ip()
        ]);
    }
}
