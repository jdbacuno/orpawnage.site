<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNumberChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $oldContact;

    public function __construct($oldContact)
    {
        $this->oldContact = $oldContact;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Contact Number Updated')
            ->line('Your contact number was recently changed from:')
            ->line($this->oldContact . ' to ' . $notifiable->contact_number)
            ->line('If you did not make this change, please secure your account.')
            ->action('Secure Account', url('/password/reset'))
            ->line('Thank you for using our application!');
    }
}
