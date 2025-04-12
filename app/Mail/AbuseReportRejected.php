<?php

namespace App\Mail;

use App\Models\AnimalAbuseReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbuseReportRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(AnimalAbuseReport $report)
    {
        $this->report = $report;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Regarding Your Animal Abuse Report #' . $this->report->report_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.abuse_rejected',
            with: [
                'report' => $this->report,
            ]
        );
    }
}
