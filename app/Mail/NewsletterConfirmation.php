<?php

namespace App\Mail;

use App\Models\NewsletterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(NewsletterSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmation d\'inscription à notre newsletter')
                    ->view('emails.confirmation')
                    ->with([
                        'email' => $this->subscription->email,
                        'unsubscribeUrl' => route('newsletter.unsubscribe', $this->subscription->unsubscribe_token),
                    ]);
    }
}
