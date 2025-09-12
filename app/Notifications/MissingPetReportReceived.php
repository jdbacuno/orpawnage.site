<?php

namespace App\Notifications;

use App\Models\MissingPetReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingPetReportReceived extends Notification implements ShouldQueue
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
      ->subject('Missing Pet Report - Received - ' . $this->report->report_number)
      ->greeting('Hello ' . $notifiable->full_name . ',')
      ->line('Thank you for submitting a missing pet report. We understand this is a difficult time, and we appreciate your trust in our system.')
      ->line('Your report has been received and is under review by our team.')
      ->line('**Report Number**: ' . $this->report->report_number)
      ->line('**Pet Name**: ' . $this->report->pet_name)
      ->line('**Last Seen**: ' . $this->report->last_seen_location . ' on ' . \Carbon\Carbon::parse($this->report->last_seen_date)->format('F j, Y'))
      ->line('You can track the status of your report in the Transactions section of our website. Once approved, your missing pet report will be shared to other registered users in our system via email.')
      ->line('You may also contact us on our official Facebook page at Orpawnage to request posting a poster of your missing pet on our page.')
      ->action('View Report Status', url('/transactions/missing-status'))
      ->line('We hope your pet is found soon.')
      ->line('Thank you for using our service.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
