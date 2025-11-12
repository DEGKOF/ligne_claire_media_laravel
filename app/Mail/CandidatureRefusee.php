<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidatureRefusee extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Candidature $candidature
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réponse à votre candidature - LIGNE CLAIRE MÉDIA+',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.candidature-refusee',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
