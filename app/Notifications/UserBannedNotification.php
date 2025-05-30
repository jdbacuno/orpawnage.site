<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserBannedNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    // UserBannedNotification.php
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Your Account Has Been Banned')
            ->line('Your account has been banned from OrPAWnage.');

        if ($this->user->ban_reason) {
            $mail->line('Reason: ' . $this->user->ban_reason);
        } else {
            $mail->line('Your account has been suspended due to multiple unsuccessful adoption applications.');
            $mail->line('To ensure fairness, we limit repeated submissions that don’t meet our guidelines.');
        }

        $mail->line('If you believe this is a mistake, please contact us at orpawnageteam@gmail.com with your username or registered email')
            ->action('Appeal Ban', 'mailto:orpawnageteam@gmail.com');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
