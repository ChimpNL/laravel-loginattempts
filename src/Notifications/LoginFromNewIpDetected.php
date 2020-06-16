<?php

namespace LamaLama\LoginAttempts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginFromNewIpDetected extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $geoIp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $geoIp)
    {
        $this->user = $user;
        $this->geoIp = $geoIp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $ip = $this->geoIp->ip;
        $name = $this->user->name;
        $email = $this->user->email;
        $location = $this->geoIp->city.', '.$this->geoIp->country;

        return (new MailMessage)
            ->success()
            ->line('A succesfull login ('.$ip.') by '.$name.' ('.$email.') from an unknown location ('.$location.') is detected.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
