<?php
// app/Http/Controllers/MembershipController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Publication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function index()
    {
        // Récupérer les breaking news
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('membership.index', compact('breakingNews'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('memberships')->whereNull('deleted_at'),
            ],
            'telephone' => 'required|string|max:20',
            'formule' => 'required|in:citoyen,ambassadeur',
            'mode_paiement' => 'required|in:mobile_money,carte_bancaire,crypto',
            'frequence' => 'required|in:mensuel,trimestriel,semestriel,annuel',
            'apparaitre_publiquement' => 'boolean',
            'charte_acceptee' => 'required|accepted',
        ], [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'adresse e-mail est obligatoire',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée',
            'telephone.required' => 'Le numéro de téléphone (WhatsApp) est obligatoire',
            'formule.required' => 'Veuillez choisir une formule d\'engagement',
            'charte_acceptee.accepted' => 'Vous devez accepter la Charte du membre citoyen LCM+',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Déterminer le montant selon la formule
        $montant = $request->formule === Membership::FORMULE_AMBASSADEUR
            ? Membership::MONTANT_AMBASSADEUR
            : Membership::MONTANT_CITOYEN;

        // Créer le membre
        $membership = Membership::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'formule' => $request->formule,
            'mode_paiement' => $request->mode_paiement,
            'frequence' => $request->frequence,
            'montant' => $montant,
            'apparaitre_publiquement' => $request->boolean('apparaitre_publiquement'),
            'statut' => Membership::STATUT_EN_ATTENTE,
            'charte_acceptee' => true,
            'charte_acceptee_at' => now(),
        ]);

        // Message de confirmation adapté à la formule
        $messageFormule = $request->formule === Membership::FORMULE_AMBASSADEUR
            ? 'Ambassadeur LCM'
            : 'Membre Citoyen';

        // Rediriger vers la page de paiement
        return redirect()->route('shop.payment', $membership->id)
            ->with('success', "Merci pour votre confiance ! Votre demande d'adhésion comme {$messageFormule} a été enregistrée. Veuillez procéder au paiement pour activer votre abonnement.");
    }
}
