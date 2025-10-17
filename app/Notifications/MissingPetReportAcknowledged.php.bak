<?php

namespace App\Notifications;

use App\Models\MissingPetReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingPetReportAcknowledged extends Notification implements ShouldQueue
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
    return (new MailMessage)
      ->subject('Your Missing Pet Report Has Been Shared - ' . $this->report->report_number)
      ->greeting('Hello ' . $notifiable->full_name . ',')
      ->line('Your missing pet report has been acknowledged by our team.')
      ->line('**Report Number:** ' . $this->report->report_number)
      ->line('**Pet Name:** ' . $this->report->pet_name)
      ->line('We have shared your report with our community members via email to help spread awareness about your missing pet.')
      ->line('Additionally, if you have not already done so, we recommend posting your missing pet information on the Orpawnage Facebook page for broader reach.')
      ->action('View Report Status', url('/transactions/missing-status'))
      ->line('We hope your pet is found soon.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
