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
      // Get the pet photos
      $petPhotos = json_decode($this->report->pet_photos, true) ?? [];
      $mainPetPhoto = !empty($petPhotos) ? $petPhotos[0] : null;

      // Get location photos
      $locationPhotos = json_decode($this->report->location_photos, true) ?? [];

      // Create mail message
      $mailMessage = (new MailMessage)
        ->subject('MISSING PET ALERT: ' . $this->report->pet_name)
        ->view(
          'emails.missing-pet-alert',
          [
            'report' => $this->report,
            'notifiable' => $notifiable,
            'mainPetPhotoUrl' => $mainPetPhoto,
            'allPetPhotos' => $petPhotos,
            'locationPhotos' => $locationPhotos,
            'isReporter' => $notifiable->id === $this->report->user_id,
          ]
        );

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
