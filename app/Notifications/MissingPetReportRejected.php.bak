<?php

namespace App\Notifications;

use App\Models\MissingPetReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingPetReportRejected extends Notification implements ShouldQueue
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
    $mail = (new MailMessage)
      ->subject('Missing Pet Report - Rejected - ' . $this->report->report_number)
      ->greeting('Hello ' . $notifiable->full_name . ',')
      ->line('We regret to inform you that your missing pet report has been rejected.');

    if ($this->report->reject_reason) {
      $mail->line('**Reason for Rejection**: ' . $this->report->reject_reason);
    }

    return $mail
      ->line('**Report Number:** ' . $this->report->report_number)
      ->line('**Pet Name:** ' . $this->report->pet_name)
      ->line('If you would like to submit a revised report or have questions about this decision, please contact us.')
      ->action('View Report Status', url('/transactions/missing-status'))
      ->line('Thank you for your understanding.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
