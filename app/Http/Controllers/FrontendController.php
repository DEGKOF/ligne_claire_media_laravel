<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Rubrique;
use App\Models\PublicationView;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Page d'accueil
     */
    public function index()
    {
        $featuredArticle = Publication::published()
            ->featured()
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->first();

        $recentArticles = Publication::published()
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->take(9)
            ->get();

        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularArticles = Publication::published()
            ->popular(5)
            ->with(['user', 'rubrique'])
            ->get();

        $rubriques = Rubrique::active()->ordered()->get();

        return view('frontend.index', compact(
            'featuredArticle',
            'recentArticles',
            'breakingNews',
            'popularArticles',
            'rubriques'
        ));
    }

    /**
     * Afficher une publication
     */
    public function showPublication(Request $request, string $slug)
    {
        $publication = Publication::where('slug', $slug)
            ->published()
            ->with(['user', 'rubrique'])
            ->firstOrFail();

        // Enregistrer la vue
        PublicationView::recordView($publication, $request);

        // Articles similaires
        $relatedArticles = Publication::published()
            ->byRubrique($publication->rubrique_id)
            ->where('id', '!=', $publication->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.publication', compact('publication', 'relatedArticles'));
    }

    /**
     * Afficher les articles d'une rubrique
     */
    public function showRubrique(Request $request, string $slug)
    {
        $rubrique = Rubrique::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $rubrique->incrementViews();

        $publications = Publication::published()
            ->byRubrique($rubrique->id)
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.rubrique', compact('rubrique', 'publications'));
    }

    /**
     * Page vidéos
     */
    public function videos()
    {
        $featuredVideo = Publication::published()
            ->byType('direct')
            ->orWhere('type', 'rediffusion')
            ->latest('published_at')
            ->first();

        $recentVideos = Publication::published()
            ->whereIn('type', ['direct', 'rediffusion', 'video_courte'])
            ->latest('published_at')
            ->take(12)
            ->get();

        $shorts = Publication::published()
            ->byType('video_courte')
            ->latest('published_at')
            ->take(8)
            ->get();

        return view('frontend.videos', compact('featuredVideo', 'recentVideos', 'shorts'));
    }

    /**
     * Recherche
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        $results = Publication::published()
            ->search($query)
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->paginate(15);

        return view('frontend.search', compact('results', 'query'));
    }
}
