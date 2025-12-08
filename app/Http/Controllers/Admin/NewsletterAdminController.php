<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterAdminController extends Controller
{
    /**
     * Liste des abonnés
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscription::query()->latest();

        // Filtre par statut
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Recherche par email
        if ($request->has('search') && $request->search) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscriptions = $query->paginate(20);

        $stats = [
            'total' => NewsletterSubscription::count(),
            'active' => NewsletterSubscription::where('is_active', true)->count(),
            'inactive' => NewsletterSubscription::where('is_active', false)->count(),
            'today' => NewsletterSubscription::whereDate('created_at', today())->count(),
        ];

        return view('admin.newsletter.index', compact('subscriptions', 'stats'));
    }

    /**
     * Supprimer un abonné
     */
    public function destroy(NewsletterSubscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.newsletter.index')
            ->with('success', 'Abonné supprimé avec succès.');
    }

    /**
     * Activer/Désactiver un abonné
     */
    public function toggleStatus(NewsletterSubscription $subscription)
    {
        if ($subscription->is_active) {
            $subscription->unsubscribe();
            $message = 'Abonné désactivé avec succès.';
        } else {
            $subscription->resubscribe();
            $message = 'Abonné réactivé avec succès.';
        }

        return redirect()->route('admin.newsletter.index')
            ->with('success', $message);
    }

    /**
     * Exporter les emails
     */
    public function export(Request $request)
    {
        $query = NewsletterSubscription::query();

        if ($request->has('status') && $request->status === 'active') {
            $query->where('is_active', true);
        }

        $emails = $query->pluck('email')->toArray();

        $filename = 'newsletter_emails_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($emails) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Date']);

            foreach (NewsletterSubscription::with([])->get() as $subscription) {
                fputcsv($file, [
                    $subscription->email,
                    $subscription->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Formulaire d'envoi de newsletter
     */
    public function sendForm()
    {
        $activeSubscribers = NewsletterSubscription::where('is_active', true)->count();

        return view('admin.newsletter.send', compact('activeSubscribers'));
    }

    /**
     * Envoyer la newsletter
     */
    public function sendNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,active,test',
            'test_email' => 'required_if:recipient_type,test|email',
        ], [
            'subject.required' => 'Le sujet est requis.',
            'message.required' => 'Le message est requis.',
            'recipient_type.required' => 'Veuillez sélectionner un type de destinataire.',
            'test_email.required_if' => 'L\'email de test est requis.',
            'test_email.email' => 'Veuillez entrer un email valide.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject = $request->subject;
        $message = $request->message;
        $recipientType = $request->recipient_type;

        // Récupérer les destinataires
        if ($recipientType === 'test') {
            $recipients = [$request->test_email];
        } else {
            $query = NewsletterSubscription::query();

            if ($recipientType === 'active') {
                $query->where('is_active', true);
            }

            $recipients = $query->pluck('email')->toArray();
        }

        if (empty($recipients)) {
            return redirect()->back()
                ->with('error', 'Aucun destinataire trouvé.');
        }

        // Envoyer les emails
        $sent = 0;
        $failed = 0;

        foreach ($recipients as $email) {
            try {
                Mail::send('emails.newsletter', [
                    'content' => $message,
                    'unsubscribeUrl' => $this->getUnsubscribeUrl($email)
                ], function ($mail) use ($email, $subject) {
                    $mail->to($email)
                        ->subject($subject);
                });
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                \Log::error('Newsletter sending failed: ' . $e->getMessage());
            }
        }

        $message = "Newsletter envoyée avec succès à {$sent} destinataire(s).";
        if ($failed > 0) {
            $message .= " {$failed} email(s) ont échoué.";
        }

        return redirect()->route('admin.newsletter.index')
            ->with('success', $message);
    }

    /**
     * Obtenir l'URL de désabonnement pour un email
     */
    private function getUnsubscribeUrl($email)
    {
        $subscription = NewsletterSubscription::where('email', $email)->first();

        if ($subscription && $subscription->unsubscribe_token) {
            return route('newsletter.unsubscribe', $subscription->unsubscribe_token);
        }

        return null;
    }
}
