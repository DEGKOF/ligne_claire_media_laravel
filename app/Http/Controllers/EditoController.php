<?php

namespace App\Http\Controllers;

use App\Models\Edito;
use App\Models\Publication;
use Illuminate\Http\Request;

class EditoController extends Controller
{
    /**
     * Afficher la page des éditos
     * - Le dernier en grand
     * - La liste des anciens en dessous
     */
    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            // ->take(5)
            ->get();
            // 'breakingNews',

        // Récupérer le dernier édito publié
        $latestEdito = Edito::getLatestPublished();

        // Récupérer les anciens éditos publiés (sauf le dernier)
        $olderEditos = Edito::getOlderPublished(9); // Limiter à 9 pour la pagination

        return view('editos.index', compact('latestEdito', 'olderEditos', 'breakingNews'));
    }

    /**
     * Afficher un édito spécifique
     */
    public function show(Edito $edito)
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            // ->take(5)
            ->get();
            // 'breakingNews',

        // Vérifier que l'édito est publié
        if (!$edito->isPublished()) {
            abort(404);
        }

        // Charger l'auteur
        $edito->load('user');

        // Récupérer les éditos récents pour la sidebar
        $recentEditos = Edito::published()
            ->where('id', '!=', $edito->id)
            ->latest()
            ->take(5)
            ->get();

        return view('editos.show', compact('edito', 'recentEditos', 'breakingNews'));
    }
}
