<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class NewPetAdded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pet;

    public function __construct($pet)
    {
        $this->pet = $pet;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can add other channels like 'database', 'sms', etc.
    }

    public function toMail($notifiable)
    {
        try {
            // Create the MailMessage instance
            $mailMessage = (new MailMessage)
                ->subject('A New Pet Has Been Added! 🐾')
                ->view('emails.new-pet-added', [
                    'pet' => $this->pet
                ]);

            // Check if there is an image path and attach it
            if ($this->pet->image_path) {
                $imagePath = storage_path('app/public/' . $this->pet->image_path);

                // Get the image extension
                $imageExtension = pathinfo($this->pet->image_path, PATHINFO_EXTENSION);

                // Determine the MIME type based on the file extension
                $mimeType = $this->getMimeTypeFromExtension($imageExtension);

                // Attach the image with the correct MIME type
                $mailMessage->attach($imagePath, [
                    'as' => 'pet-image.' . $imageExtension,  // Use the original file extension
                    'mime' => $mimeType                    // Use the dynamically determined MIME type
                ]);
            }

            return $mailMessage;
        } catch (\Exception $e) {
            Log::error('Email sending failed for NewPetAdded: ' . $e->getMessage());
            return (new MailMessage)->subject('Error Sending Email');
        }
    }

    // Helper function to determine the MIME type based on the file extension
    protected function getMimeTypeFromExtension($extension)
    {
        $mimeTypes = [
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'svg'  => 'image/svg+xml',
        ];

        // Return the MIME type for the given extension, or default to 'image/jpeg'
        return $mimeTypes[$extension] ?? 'image/jpeg';
    }
}
