<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AnimalAbuseReport;
use Carbon\Carbon;

class AbuseReportRejected extends Notification implements ShouldQueue
{
  use Queueable;

  protected $report;

  public function __construct(AnimalAbuseReport $report)
  {
    $this->report = $report;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $incidentDate = Carbon::parse($this->report->incident_date);

    return (new MailMessage)
      ->subject('Animal Abuse Report - Rejected - #' . $this->report->report_number)
      ->greeting('Hello ' . ($this->report->full_name ?: 'Anonymous') . ',')
      ->line('We regret to inform you that we were unable to take action on your report.')
      ->line('**Report Number:** #' . $this->report->report_number)
      ->line('**Status:** Rejected')
      ->line('**Incident Date:** ' . $incidentDate->format('F j, Y'))
      ->line('**Location:** ' . $this->report->incident_location)
      ->line('**Reason for Rejecting:** ' . $this->report->reject_reason)
      ->line('After careful review, we were unable to verify the details of your report or take action at this time.')
      ->line('If you believe this decision was made in error or have additional information to share, please contact us with your report number.')
      ->action('Contact Support', url('/contact'))
      ->line('We appreciate your concern for animal welfare and encourage you to report any future incidents you witness.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
