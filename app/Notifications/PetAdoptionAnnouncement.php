<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\Pet;

class PetAdoptionAnnouncement extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Pet */
    protected $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    /**
     * Get the notification's delivery channels.
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $speciesLabel = $this->pet->species === 'feline' ? 'Cat' : 'Dog';
        $petNumber = $this->pet->pet_number;

        $petName = $this->pet->pet_name && strtolower($this->pet->pet_name) !== 'n/a'
            ? "{$this->pet->pet_name} (#{$petNumber})"
            : "Pet #{$petNumber}";

        $ageDescription = $this->pet->age
            ? "{$this->pet->age}-year-old"
            : '';

        $adoptionDate = now()->format('F j, Y');

        $mail = (new MailMessage)
            ->subject("{$speciesLabel} #{$petNumber} Has Found a Loving Home!")
            ->greeting('🎉 Great News!')
            ->line("We're thrilled to announce that our {$ageDescription} {$speciesLabel}, **{$petName}**, has been successfully adopted!")
            ->line("This sweet {$speciesLabel} found their forever home on **{$adoptionDate}**.")
            ->line("Thank you to everyone who supported this {$speciesLabel}'s journey and considered giving them a home.")
            ->line("Stay tuned for more adoption success stories!")
            ->action('View Our Available Pets', url('/services/adopt-a-pet'))
            ->line("Together, we're making a difference in these animals' lives.")
            ->salutation("With gratitude,\nThe Orpawnage Team");

        // ✅ Attach the pet image (same pattern as archive notification)
        if ($this->pet->image_path && Storage::disk('public')->exists($this->pet->image_path)) {
            $extension = pathinfo($this->pet->image_path, PATHINFO_EXTENSION);

            $mimeType = match (strtolower($extension)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'bmp' => 'image/bmp',
                'svg' => 'image/svg+xml',
                default => 'image/jpeg',
            };

            $mail->attach(Storage::disk('public')->path($this->pet->image_path), [
                'as' => "{$this->pet->pet_name}_{$this->pet->pet_number}.{$extension}",
                'mime' => $mimeType,
            ]);
        }

        return $mail;
    }
}
