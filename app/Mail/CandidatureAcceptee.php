<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidatureAcceptee extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Candidature $candidature
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Félicitations ! Votre candidature a été acceptée - LIGNE CLAIRE MÉDIA+',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.candidature-acceptee',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
