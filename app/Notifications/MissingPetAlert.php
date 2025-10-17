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

      // Build the email message
      $mailMessage = (new MailMessage)
        ->subject('MISSING PET ALERT: ' . $this->report->pet_name)
        ->greeting('MISSING PET ALERT')
        ->line('**Pet Name:** ' . $this->report->pet_name)
        ->line('**Last Seen Date:** ' . date('F j, Y', strtotime($this->report->last_seen_date)))
        ->line('**Last Seen Location:** ' . $this->report->last_seen_location)
        ->line('**Message/Description:** ' . $this->report->pet_description)
        ->line('')
        ->line('**Please check the attached images of the missing pet and location photos.**')
        ->line('')
        ->line('**If you have seen this pet, please contact:**')
        ->line('**Owner:** ' . $this->report->owner_name)
        ->line('**Phone:** ' . $this->report->contact_no)
        ->line('')
        ->action('You may also help us find other missing pets', url('/missing-pets-browse'));

      // Add reporter-specific message
      if ($notifiable->id === $this->report->user_id) {
        $mailMessage->line('')
          ->line('---')
          ->line('**Note to reporter:** This alert has been sent to all registered users in our community. You can check the status of your report anytime.')
          ->action('Check Missing Pet Status', url('/transactions/missing-status'));
      }

      $mailMessage->line('')
        ->line('Thank you for helping us find ' . $this->report->pet_name . '!')
        ->salutation('The Orpawnage Team');

      // Attach pet photos
      foreach ($petPhotos as $index => $photoPath) {
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $photoPath));
        if (file_exists($fullPath)) {
          $mailMessage->attach($fullPath, [
            'as' => $this->report->pet_name . '_photo_' . ($index + 1) . '.' . pathinfo($photoPath, PATHINFO_EXTENSION),
            'mime' => $this->getMimeTypeFromExtension(pathinfo($photoPath, PATHINFO_EXTENSION)),
          ]);
        }
      }

      // Attach location photos
      foreach ($locationPhotos as $index => $photoPath) {
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $photoPath));
        if (file_exists($fullPath)) {
          $mailMessage->attach($fullPath, [
            'as' => 'location_photo_' . ($index + 1) . '.' . pathinfo($photoPath, PATHINFO_EXTENSION),
            'mime' => $this->getMimeTypeFromExtension(pathinfo($photoPath, PATHINFO_EXTENSION)),
          ]);
        }
      }

      return $mailMessage;
    } catch (\Exception $e) {
      Log::error('Email sending failed for MissingPetAlert: ' . $e->getMessage());

      return (new MailMessage)
        ->subject('Error Sending Missing Pet Alert Email')
        ->line('There was an error sending the missing pet alert. Please contact support.')
        ->salutation('The Orpawnage Team');
    }
  }

  /**
   * Helper function to determine the MIME type based on the file extension
   */
  protected function getMimeTypeFromExtension($extension)
  {
    $mimeTypes = [
      'jpeg' => 'image/jpeg',
      'jpg'  => 'image/jpeg',
      'png'  => 'image/png',
      'gif'  => 'image/gif',
      'bmp'  => 'image/bmp',
      'svg'  => 'image/svg+xml',
      'webp' => 'image/webp',
    ];

    return $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
  }
}
