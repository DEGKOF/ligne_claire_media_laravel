<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Rubrique;
use App\Models\User;
use App\Models\PublicationView;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_publications' => Publication::count(),
            'published_publications' => Publication::published()->count(),
            'draft_publications' => Publication::draft()->count(),
            'total_views' => Publication::sum('views_count'),
            'total_users' => User::count(),
            'total_rubriques' => Rubrique::active()->count(),
        ];

        // Publications récentes
        $recentPublications = Publication::with(['user', 'rubrique'])
            ->latest()
            ->take(5)
            ->get();

        // Rubriques les plus populaires
        $popularRubriques = Rubrique::orderByDesc('views_count')
            ->take(5)
            ->get();

        // Articles les plus vus
        $popularArticles = Publication::published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // Vues des 7 derniers jours
        $viewsLast7Days = PublicationView::select(
                DB::raw('DATE(viewed_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('viewed_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Publications par type
        $publicationsByType = Publication::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type');

        // Auteurs les plus actifs
        $topAuthors = User::withCount('publications')
            ->having('publications_count', '>', 0)
            ->orderByDesc('publications_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPublications',
            'popularRubriques',
            'popularArticles',
            'viewsLast7Days',
            'publicationsByType',
            'topAuthors'
        ));
    }
}
