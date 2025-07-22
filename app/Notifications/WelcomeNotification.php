<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail']; // Send via email (or add other channels like 'database')
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->line('Thank you for signing up using your Google account!')
            ->line('Your account has been created successfully.')
            ->action('Visit Your Dashboard', url('/'))
            ->line('If you did not request this, please contact support.');
    }
}
