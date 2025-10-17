<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use App\Models\SurrenderApplication;

class SurrenderStatusNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected $applicationId;
  protected $oldSurrenderDate;

  public function __construct($applicationId, $oldSurrenderDate = null)
  {
    $this->applicationId = $applicationId;
    $this->oldSurrenderDate = $oldSurrenderDate;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $application = SurrenderApplication::findOrFail($this->applicationId);
    $status = $application->status;
    $transactionNumber = $application->transaction_number;

    $statusSubjectMap = [
      'to be confirmed' => 'Confirm Your Surrender Application',
      'confirmed' => 'Application Confirmed',
      'completed' => 'Completed',
      'rejected' => 'Rejected',
    ];

    $customSubject = $statusSubjectMap[$status] ?? ucwords($status);

    $mailMessage = (new MailMessage)
      ->subject("Surrender Application - {$customSubject} - Transaction #{$transactionNumber}")
      ->greeting('Hello ' . $application->full_name . ',')
      ->line('**Transaction #:** ' . $transactionNumber);

    if ($application->pet_name) {
      $mailMessage->line('**Animal Name:** ' . $application->pet_name);
    }

    $mailMessage->line('**Application Date:** ' . $application->created_at->format('F j, Y'));

    switch ($application->status) {
      case 'to be confirmed':
        $mailMessage
          ->line('We have received your surrender application!')
          ->line('Please confirm within **24 hours** to proceed with the surrender process.')
          ->action('Confirm Application', URL::signedRoute('surrender.confirm', ['id' => $application->id]))
          ->line('Failure to confirm within 24 hours will automatically cancel your application.')
          ->line('Thank you for responsibly surrendering your animal.');
        break;

      case 'confirmed':
        $mailMessage
          ->line('âœ… Your surrender application has been **confirmed**!')
          ->line('Our team will now review your application and contact you as soon as we can to discuss the surrender process.')
          ->line('**What to expect next:**')
          ->line('- Our team will call you to determine if you can bring the animal to our facility')
          ->line('- For certain situations, we may arrange for the animal to be retrieved')
          ->line('- Please keep your phone available for our call')
          ->line('Thank you for your patience and for choosing to surrender responsibly!');
        break;

      case 'completed':
        $mailMessage
          ->line('í¿¡ Your surrender process is now **complete**.')
          ->line('**Completion Date:** ' . $application->updated_at->format('F j, Y'))
          ->line("Thank you for responsibly surrendering your animal.")
          ->line('í°¾ We will provide proper care for the animal and work to find it a new home if appropriate.');
        break;

      case 'rejected':
        $mailMessage
          ->line('We regret to inform you that your surrender application has been **rejected**.')
          ->line('**Reason for Rejecting:** ' . $application->reject_reason)
          ->line('For any questions, please contact our office.');
        break;
    }

    return $mailMessage
      ->line('For any questions, please contact us at orpawnagedevelopers@gmail.com and reference your **transaction number**.')
      ->salutation("Thank you,\nOrpawnage Team");
  }
}
