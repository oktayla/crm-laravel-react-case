<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class DailyReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Carbon $today,
        public array $reportData = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->generateSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.reports.daily');
    }

    protected function generateSubject(): string
    {
        return "Daily Report for {$this->today->toDateString()}";
    }
}
