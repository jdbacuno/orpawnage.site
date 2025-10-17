<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AnimalAbuseReport;

class AbuseReportReceived extends Notification implements ShouldQueue
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
    return (new MailMessage)
      ->subject('Animal Abuse Report - Waiting for Review - #' . $this->report->report_number)
      ->greeting('Hello ' . (ucwords($this->report->full_name) ?: '') . ',')
      ->line('We have received your report and it is currently under review.')
      ->line('**Report Number:** #' . $this->report->report_number)
      ->line('**Incident Date:** ' . \Carbon\Carbon::parse($this->report->incident_date)->format('F j, Y'))
      ->line('**Location:** ' . $this->report->incident_location)
      ->line('**Animal Type:** ' . ucfirst($this->report->species))
      ->line('**Status:** Pending Review')
      ->line('Our team will review your report and take appropriate action. You will receive another notification once we have processed your report.')
      ->action('View Report Status', url('/transactions/abused-status'))
      ->line('Thank you for helping to protect animals in our community.')
      ->salutation("Regards,\nOrpawnage Team");
  }
}
