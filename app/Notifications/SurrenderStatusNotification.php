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

  protected $application;
  protected $oldSurrenderDate;

  public function __construct(SurrenderApplication $application, $oldSurrenderDate = null)
  {
    $this->application = $application;
    $this->oldSurrenderDate = $oldSurrenderDate;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $status = $this->application->status;
    $transactionNumber = $this->application->transaction_number;

    $statusSubjectMap = [
      'to be confirmed' => 'Confirm Your Surrender Application',
      'confirmed' => 'Application Confirmed',
      'to be scheduled' => 'Set a Surrender Date',
      'surrender on-going' => 'Scheduled for Surrender',
      'completed' => 'Completed',
      'rejected' => 'Rejected',
    ];

    $customSubject = $statusSubjectMap[$status] ?? ucwords($status);

    $mailMessage = (new MailMessage)
      ->subject("Surrender Application - {$customSubject} - Transaction #{$transactionNumber}")
      ->greeting('Hello ' . $this->application->full_name . ',')
      ->line('**Transaction #:** ' . $transactionNumber);

    if ($this->application->pet_name) {
      $mailMessage->line('**Animal Name:** ' . $this->application->pet_name);
    }

    $mailMessage->line('**Application Date:** ' . $this->application->created_at->format('F j, Y'));

    switch ($this->application->status) {
      case 'to be confirmed':
        $mailMessage
          ->line('We have received your surrender application!')
          ->line('Please confirm within **24 hours** to proceed with the surrender process.')
          ->action('Confirm Application', URL::signedRoute('surrender.confirm', ['id' => $this->application->id]))
          ->line('Failure to confirm within 24 hours will automatically cancel your application.')
          ->line('Thank you for responsibly surrendering your animal.');
        break;

      case 'confirmed':
        $mailMessage
          ->line('✅ Your surrender application has been **confirmed**!')
          ->line('We are now preparing for your surrender. This may take **3–5 business days**.')
          ->line('You will receive another email to select a schedule to bring your animal to our facility.')
          ->line('Thank you for your patience and for choosing to surrender responsibly!');
        break;

      case 'to be scheduled':
        $mailMessage
          ->line('📅 You can now select a schedule to bring your animal to our facility!')
          ->line('Your application is now ready for **scheduling**.')
          ->action('Select Schedule', url('/transactions/surrender-status'))
          ->line('Please schedule within **48 hours** to avoid cancellation.')
          ->line('**Available time slots:** 8:00 AM to 4:00 PM, Monday to Friday.')
          ->line('**What to bring on your scheduled date:**')
          ->line('- Valid government-issued ID')
          ->line('- Copy of this confirmation')
          ->line('- Any medical records for the animal (if available)');
        break;

      case 'surrender on-going':
        $mailMessage
          ->line('📅 Your surrender appointment is scheduled!')
          ->line('**Scheduled Surrender Date:** ' . $this->application->surrender_date->format('F j, Y'))
          ->line('**Location:** Angeles City Veterinary Office')
          ->line('**On your surrender day, bring:**')
          ->line('- A valid government-issued ID')
          ->line('- Your transaction confirmation email')
          ->line('- The animal in a secure carrier or leash')
          ->line('⚠️ Failure to visit after **3 business days** from your scheduled date will cancel the surrender process.')
          ->line('📸 We\'ll take an official photo of the animal for our records.');
        break;

      case 'completed':
        $mailMessage
          ->line('🏡 Your surrender process is now **complete**.')
          ->line('**Completion Date:** ' . $this->application->updated_at->format('F j, Y'))
          ->line("Thank you for responsibly surrendering your animal.")
          ->line('🐾 We will provide proper care for the animal and work to find it a new home if appropriate.');
        break;

      case 'rejected':
        $mailMessage
          ->line('We regret to inform you that your surrender application has been **rejected**.')
          ->line('**Reason for Rejecting:** ' . $this->application->reject_reason)
          ->line('For any questions, please contact our office.');
        break;
    }

    return $mailMessage
      ->line('For any questions, please contact us at orpawnagedevelopers@gmail.com and reference your **transaction number**.')
      ->salutation("Thank you,\nOrpawnage Team");
  }
}
