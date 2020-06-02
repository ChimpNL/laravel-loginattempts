<?php

namespace LamaLama\LoginAttempts\Listeners;

use App\Models\User;
use LamaLama\LoginAttempts\Events\AuthSucceeded;
use LamaLama\LoginAttempts\Models\LoginAttempt;
use LamaLama\LoginAttempts\Notifications\LoginFromNewIpDetected;
use Notification;
use Torann\GeoIP\Facades\GeoIP;

class RecordSuccesfullLogin
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
     * @param AuthSucceeded $event
     *
     * @return void
     */
    public function handle(AuthSucceeded $event)
    {
        if (! config('login-attempts.record_successful_login')) {
            return;
        }

        $loginAttempts = LoginAttempt::where('email', $event->user->email)
            ->where('ip', request()->ip())
            ->get();

        if ($loginAttempts->isEmpty()) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'owner');
            })->get();

            $geoIp = geoip()->getLocation(request()->ip());
            Notification::send($users, new LoginFromNewIpDetected($event->user, $geoIp));
        }

        LoginAttempt::create([
            'event' => 'succeeded',
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
        ]);
    }
}
