<?php

namespace App\Mail;

use App\Models\Wedding;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeddingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Wedding $wedding,
        public int $daysLeft,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "⏰ {$this->daysLeft} Hari Lagi Menuju Hari Istimewa Anda!");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.wedding-reminder');
    }
}
