<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class DonationController extends Controller
{
    public function process(Request $request)
    {
        // Valider le montant
        $validated = $request->validate([
            'amount' => 'required|numeric|min:500'
        ]);

        // Récupérer les breaking news
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        // Rediriger vers la page soutient avec le montant
        return view('soutient', [
            'breakingNews' => $breakingNews,
            'prefilledAmount' => $validated['amount']
        ]);
    }
}
