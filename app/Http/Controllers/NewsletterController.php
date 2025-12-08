<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterConfirmation;

class NewsletterController extends Controller
{

    // MAIL_MAILER=smtp
    // MAIL_HOST=smtp.mailtrap.io
    // MAIL_PORT=2525
    // MAIL_USERNAME=your_username
    // MAIL_PASSWORD=your_password
    // MAIL_ENCRYPTION=tls
    // MAIL_FROM_ADDRESS=noreply@votresite.com
    // MAIL_FROM_NAME="${APP_NAME}"
    /**
     * Inscription à la newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('home')
                ->withErrors($validator)
                ->withInput()
                ->with('newsletter_error', $validator->errors()->first());
        }

        $email = $request->email;

        // Vérifier si l'email existe déjà
        $subscription = NewsletterSubscription::where('email', $email)->first();

        if ($subscription) {
            // Si déjà abonné et actif
            if ($subscription->is_active) {
                return redirect()->route('home')
                    ->with('newsletter_info', 'Vous êtes déjà abonné à notre newsletter.');
            }

            // Si existait mais était désabonné, réactiver
            $subscription->resubscribe();

            // Envoyer l'email de confirmation
            try {
                Mail::to($email)->send(new NewsletterConfirmation($subscription));
            } catch (\Exception $e) {
                // Logger l'erreur mais ne pas bloquer l'inscription
                \Log::error('Erreur envoi email newsletter: ' . $e->getMessage());
            }

            return redirect()->route('home')
                ->with('newsletter_success', 'Votre abonnement a été réactivé avec succès !');
        }

        // Créer un nouveau abonnement
        $subscription = NewsletterSubscription::create([
            'email' => $email,
            'ip_address' => $request->ip(),
        ]);

        // Envoyer l'email de confirmation
        try {
            Mail::to($email)->send(new NewsletterConfirmation($subscription));
        } catch (\Exception $e) {
            // Logger l'erreur mais ne pas bloquer l'inscription
            \Log::error('Erreur envoi email newsletter: ' . $e->getMessage());
        }

        return redirect()->route('home')
            ->with('newsletter_success', 'Merci pour votre abonnement ! Vous recevrez bientôt nos actualités.');
    }

    /**
     * Désabonnement
     */
    public function unsubscribe(Request $request, $token)
    {
        $subscription = NewsletterSubscription::where('unsubscribe_token', $token)->first();

        if (!$subscription) {
            return redirect()->route('home')
                ->with('newsletter_error', 'Lien de désabonnement invalide.');
        }

        if (!$subscription->is_active) {
            return redirect()->route('home')
                ->with('newsletter_info', 'Vous êtes déjà désabonné de notre newsletter.');
        }

        $subscription->unsubscribe();

        return redirect()->route('home')
            ->with('newsletter_success', 'Vous avez été désabonné avec succès de notre newsletter.');
    }
}
