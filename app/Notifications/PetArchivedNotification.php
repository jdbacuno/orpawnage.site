<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pet;

class PetArchivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $label = $this->pet->species === 'feline' ? 'Cat' : 'Dog';
        $petNumber = $this->pet->pet_number;
        $petName = $this->pet->pet_name !== 'N/A' ? $this->pet->pet_name : 'Unnamed';

        return (new MailMessage)
            ->subject("{$label} #{$petNumber} Has Been Archived")
            ->greeting("Pet Archive Notification")
            ->line("We're archiving {$label} #{$petNumber} ({$petName}) from our active records.")
            ->line('**Reason for Archiving:**')
            ->line($this->pet->archive_reason)
            ->when($this->pet->archive_notes, function ($mail) {
                $mail->line('**Additional Notes:**')
                    ->line($this->pet->archive_notes);
            })
            ->line('This pet is no longer available for adoption.')
            ->salutation("Regards,\n" . config('app.name'));
    }
}
