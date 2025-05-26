<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PasswordChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $isAdmin = $notifiable->isAdmin ? 'admin#settingsModal?tab=password-tab' : '#settingsModal?tab=password-tab';

        return (new MailMessage)
            ->subject('Your Password Has Been Changed')
            ->line('Your account password was recently changed.')
            ->line('If you did not make this change, please secure your account immediately.')
            ->action('Secure Your Account', url('http://orpawnage.test/' . $isAdmin))
            ->line('Thank you for using our application!');
    }
}
