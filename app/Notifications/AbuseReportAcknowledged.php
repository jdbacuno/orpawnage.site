<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AnimalAbuseReport;
use Carbon\Carbon;

class AbuseReportAcknowledged extends Notification implements ShouldQueue
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
    // Parse the incident_date to ensure it's a Carbon instance
    $incidentDate = Carbon::parse($this->report->incident_date);

    return (new MailMessage)
      ->subject('Animal Abuse Report - Reviewed and Acknowledged - #' . $this->report->report_number)
      ->greeting('Hello ' . ($this->report->full_name ?: 'Anonymous') . ',')
      ->line('We have reviewed your report and verified its validity.')
      ->line('**Report Number:** #' . $this->report->report_number)
      ->line('**Status:** Action Taken')
      ->line('**Incident Date:** ' . $incidentDate->format('F j, Y'))
      ->line('Our team has investigated your report and will be taking appropriate action to address the situation.')
      ->line('If you have any additional information or questions regarding this case, please reference the report number above when contacting us.')
      ->action('View Report Details', url('/transactions/abused-status'))
      ->line('Thank you for helping to protect animals in our community.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
