<?php

namespace App\Notifications;

use App\Models\MissingPetReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingPetReportApproved extends Notification implements ShouldQueue
{
  use Queueable;

  protected $report;

  public function __construct(MissingPetReport $report)
  {
    $this->report = $report;
  }

  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  public function toMail(object $notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Your Missing Pet Report Has Been Approved - ' . $this->report->report_number)
      ->greeting('Hello ' . $notifiable->full_name . ',')
      ->line('Great news! Your missing pet report has been approved and is now posted on our website.')
      ->line('**Report Number:** ' . $this->report->report_number)
      ->line('**Pet Name:** ' . $this->report->pet_name)
      ->line('**Last Seen:** ' . $this->report->last_seen_location . ' on ' . \Carbon\Carbon::parse($this->report->last_seen_date)->format('F j, Y'))
      ->line('Your report has been posted on our website and shared with all registered users in our community via email to help spread awareness.')
      ->line('**Important:** You can repost your report every 5 days to keep it at the top of our listings. You can also mark your pet as found once reunited.')
      ->action('View Your Post', url('/missing-pets-browse'))
      ->line('Additionally, we recommend posting your missing pet information on the Orpawnage Facebook page for broader reach.')
      ->line('We hope your pet is found soon.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
