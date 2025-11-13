<?php
// app/Http/Controllers/MembershipController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Publication;
use Illuminate\Support\Facades\Validator;

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
            'type_membre' => 'required|in:individuel,association,entreprise',
            'civilite' => 'required_if:type_membre,individuel|in:M.,Mme,Mlle',
            'nom' => 'required|string|max:255',
            'prenom' => 'required_if:type_membre,individuel|string|max:255',
            'nom_association' => 'required_if:type_membre,association|string|max:255',
            'nom_entreprise' => 'required_if:type_membre,entreprise|string|max:255',
            'date_naissance' => 'required_if:type_membre,individuel|date',
            'lieu_naissance' => 'required_if:type_membre,individuel|string|max:255',
            'nationalite' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'adresse_postale' => 'required|string|max:500',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'montant' => 'required|numeric|min:1000',
            'mode_paiement' => 'required|in:mobile_money,virement,especes',
        ]);

        // dd($validator);
        if ($validator->fails()) {
            dd($validator->errors());
            // return back()->withErrors($validator)->withInput();
        }

        // Créer le membre
        $membership = Membership::create([
            'type_membre' => $request->type_membre,
            'civilite' => $request->civilite,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'nom_association' => $request->nom_association,
            'nom_entreprise' => $request->nom_entreprise,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'nationalite' => $request->nationalite,
            'profession' => $request->profession,
            'adresse_postale' => $request->adresse_postale,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'status' => 'pending',
        ]);

        // Rediriger vers la page de paiement
        return redirect()->route('shop.payment', $membership->id)
            ->with('success', 'Votre demande d\'adhésion a été enregistrée. Veuillez procéder au paiement.');
    }
}
