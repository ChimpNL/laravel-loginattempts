<?php

namespace App\Listeners;

use App\Events\AuthSucceeded;
use App\Models\LoginAttempt;
use App\Models\User;
use App\Notifications\LoginFromNewIpDetected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;
use Torann\GeoIP\Facades\GeoIP;

class RecordSuccesfullLoginAttempt
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
     * @param  AuthSucceeded  $event
     * @return void
     */
    public function handle(AuthSucceeded $event)
    {
        $loginAttempts = LoginAttempt::where('email', $event->user->email)
            ->where('ip', request()->ip())
            ->get();

        if ($loginAttempts->isEmpty()) {
            $users = User::whereHas('roles', function($q) {
                $q->where('name', 'owner');
            })->get();

            $geoIp = geoip()->getLocation(request()->ip());
            Notification::send($users, new LoginFromNewIpDetected($event->user, $geoIp));
        }

        LoginAttempt::create([
            'event' => 'succeeded',
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip()
        ]);
    }
}
