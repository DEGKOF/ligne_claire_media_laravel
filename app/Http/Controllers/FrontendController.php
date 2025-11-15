<?php

namespace App\Http\Controllers;

use App\Models\Rubrique;
use App\Models\Publication;
use Illuminate\Http\Request;
use App\Services\BRVMService;
use App\Models\PublicationView;
use App\Services\YahooFinanceService;

class FrontendController extends Controller
{
    /**
     * Page d'accueil
     */
    public function index(YahooFinanceService $marketService, BRVMService $brvmService )
    {
        // Récupération des données initiales
        // $marketData = $marketService->getMarketData();

        // Récupération des données initiales (Yahoo + BRVM)
        $marketData = array_merge(
            $marketService->getMarketData(),
            $brvmService->getMarketData()
        );

        $featuredArticles = Publication::published()
            ->featured()
            ->with(['user', 'rubrique'])
            ->latest('published_at')->take(5)->get();
            // ->first();

        $recentArticles = Publication::published()
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->take(21)
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

        // meta_keywords
        $metaKeywords = Publication::where('type', 'article')
            ->whereNotNull('meta_title')
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        // dd($featuredArticles);

        return view('frontend.index', compact(
            'marketData',
            'featuredArticles',
            'recentArticles',
            'breakingNews',
            'popularArticles',
            'rubriques',
            'metaKeywords'
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


        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // 'breakingNews'

        // Enregistrer la vue
        PublicationView::recordView($publication, $request);

        // Articles similaires
        $relatedArticles = Publication::published()
            ->byRubrique($publication->rubrique_id)
            ->where('id', '!=', $publication->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.publication', compact('publication', 'relatedArticles', 'breakingNews'));
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


        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // , 'breakingNews'

        $publications = Publication::published()
            ->byRubrique($rubrique->id)
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.rubrique', compact('rubrique', 'publications', 'breakingNews'));
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

        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // , 'breakingNews'

        return view('frontend.videos', compact('featuredVideo', 'recentVideos', 'shorts', 'breakingNews'));
    }

    /**
     * Recherche
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            // return redirect()->route('home');
        $query = "Votre recherche ici";
        }

        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // , 'breakingNews'

        $results = Publication::published()
            ->search($query)
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->paginate(15);

        return view('frontend.search', compact('results', 'query', 'breakingNews'));
    }

    public function direct()
    {
        $featuredArticle = Publication::published()
            ->featured()
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->first();

        $recentArticles = Publication::published()
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->take(12)
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

        return view('frontend.direct', compact(
            'featuredArticle',
            'recentArticles',
            'breakingNews',
            'popularArticles',
            'rubriques'
        ));
    }

    public function replay()
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

        return view('frontend.replay', compact(
            'featuredArticle',
            'recentArticles',
            'breakingNews',
            'popularArticles',
            'rubriques'
        ));
    }

    public function buyNewsPaper()
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

        return view('frontend.buy-news-paper', compact(
            'featuredArticle',
            'recentArticles',
            'breakingNews',
            'popularArticles',
            'rubriques'
        ));
    }
}
