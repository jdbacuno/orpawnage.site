<?php

namespace App\Notifications;

use App\Models\MissingPetReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MissingPetAlert extends Notification implements ShouldQueue
{
  use Queueable;

  protected $report;

  /**
   * Create a new notification instance.
   */
  public function __construct(MissingPetReport $report)
  {
    $this->report = $report;
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

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    try {
      // Decode photo arrays
      $petPhotos = json_decode($this->report->pet_photos, true) ?? [];
      $locationPhotos = json_decode($this->report->location_photos, true) ?? [];

      // Determine main pet photo
      $mainPetPhoto = !empty($petPhotos) ? $petPhotos[0] : null;

      // Filter out the main photo from other pet photos
      $otherPetPhotos = array_values(array_filter($petPhotos, function ($photo) use ($mainPetPhoto) {
        return $photo !== $mainPetPhoto;
      }));

      // Get up to 3 pet photos for display
      $displayPetPhotos = array_slice($otherPetPhotos, 0, 3);

      // Attach the rest (excluding main + first 3)
      $remainingPetPhotos = array_slice($otherPetPhotos, 3);

      // Get up to 3 location photos for display
      $displayLocationPhotos = array_slice($locationPhotos, 0, 3);

      // Attach the rest of the location photos
      $remainingLocationPhotos = array_slice($locationPhotos, 3);

      $mailMessage = (new MailMessage)
        ->subject('MISSING PET ALERT: ' . $this->report->pet_name)
        ->view(
          'emails.missing-pet-alert',
          [
            'report' => $this->report,
            'notifiable' => $notifiable,
            'mainPetPhotoUrl' => $mainPetPhoto,
            'allPetPhotos' => $displayPetPhotos,
            'locationPhotos' => $displayLocationPhotos,
            'isReporter' => $notifiable->id === $this->report->user_id,
          ]
        );

      // Attach extra pet photos
      foreach ($remainingPetPhotos as $photoPath) {
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $photoPath));
        if (file_exists($fullPath)) {
          $mailMessage->attach($fullPath, [
            'as' => basename($photoPath),
            'mime' => $this->getMimeTypeFromExtension(pathinfo($photoPath, PATHINFO_EXTENSION)),
          ]);
        }
      }

      // Attach extra location photos
      foreach ($remainingLocationPhotos as $photoPath) {
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $photoPath));
        if (file_exists($fullPath)) {
          $mailMessage->attach($fullPath, [
            'as' => basename($photoPath),
            'mime' => $this->getMimeTypeFromExtension(pathinfo($photoPath, PATHINFO_EXTENSION)),
          ]);
        }
      }

      return $mailMessage;
    } catch (\Exception $e) {
      Log::error('Email sending failed for MissingPetAlert: ' . $e->getMessage());
      return (new MailMessage)->subject('Error Sending Missing Pet Alert Email');
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
    return $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
  }
}
