<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidatureRecue extends Mailable
{
    use Queueable, SerializesModels;

    public $candidature;

    /**
     * Create a new message instance.
     */
    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de réception de votre candidature — LIGNE CLAIRE MÉDIA+',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.candidature-recue',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
