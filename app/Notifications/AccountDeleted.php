<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDeleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Account Deletion Confirmation')
            ->line('We regret to inform you that your account has been deleted permanently.')
            ->line('All your personal data has been removed from our systems.')
            ->line('Your account cannot be recovered at this point.')
            ->action('Contact Support', url('/contact'))
            ->line('Thank you for having been with us.');
    }
}
