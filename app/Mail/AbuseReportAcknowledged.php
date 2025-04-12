<?php

namespace App\Mail;

use App\Models\AnimalAbuseReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbuseReportAcknowledged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $report;

    /**
     * Create a new message instance.
     */
    public function __construct(AnimalAbuseReport $report)
    {
        $this->report = $report;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Animal Abuse Report #' . $this->report->report_number . ' - Action Taken',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.abuse_acknowledged',
            with: [
                'report' => $this->report
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
