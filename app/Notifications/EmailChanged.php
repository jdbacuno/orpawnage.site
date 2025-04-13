<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Email Address Changed')
            ->line('The email address associated with your account was recently changed.')
            ->line('New email address: ' . $this->user->email)
            ->line('If you did not make this change, please secure your account immediately.')
            ->action('Secure Account', url('/password/reset'))
            ->line('Thank you for using our application!');
    }
}
