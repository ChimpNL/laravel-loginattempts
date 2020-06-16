<?php

namespace LamaLama\LoginAttempts\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use LamaLama\LoginAttempts\Models\LoginAttempt;
use LamaLama\LoginAttempts\Notifications\LoginFromNewIpDetected;
use Notification;
use Torann\GeoIP\Facades\GeoIP;

class UserEventSubscriber
{
    /**
     * Handle recordSuccesfullLogin.
     */
    public function recordSuccesfullLogin($event)
    {
        if (! config('login-attempts.record_successful_login')) {
            return;
        }

        $loginAttempt = LoginAttempt::whereEvent('succeeded')
            ->whereUserId($event->user->id)
            ->whereEmail($event->user[config('login-attempts.email_column')])
            ->whereIp(request()->ip())
            ->first();

        LoginAttempt::create([
            'event' => 'succeeded',
            'user_id' => $event->user->id,
            'email' => $event->user[config('login-attempts.email_column')],
            'ip' => request()->ip(),
        ]);

        if (! $loginAttempt) {
            return;
        }

        $emails = config('login-attempts.notify_email');
        $emails = explode(',', preg_replace('/\s+/', '', $emails));

        $geoIp = geoip()->getLocation(request()->ip());

        foreach ($emails as $email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
              continue;
            }

            Notification::route('mail', $email)->notify(
                new LoginFromNewIpDetected($event->user, $geoIp)
            );
        }
    }

    /**
     * Handle recordFailedLogin.
     */
    public function recordFailedLogin($event)
    {
        if (! config('login-attempts.record_failed_login')) {
            return;
        }

        LoginAttempt::create([
            'event' => 'failed',
            'user_id' => null,
            'email' => $event->credentials['email'],
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'LamaLama\LoginAttempts\Listeners\UserEventSubscriber@recordSuccesfullLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Failed',
            'LamaLama\LoginAttempts\Listeners\UserEventSubscriber@recordFailedLogin'
        );
    }
}
