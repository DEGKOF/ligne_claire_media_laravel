<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Rubrique;
use App\Models\User;
use App\Models\PublicationView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['admin', 'master_admin']);

        // Query de base pour les publications
        $publicationsQuery = $isAdmin
            ? Publication::query()
            : Publication::where('user_id', $user->id);

        $stats = [
            'total_publications' => (clone $publicationsQuery)->count(),
            'published_publications' => (clone $publicationsQuery)->published()->count(),
            'draft_publications' => (clone $publicationsQuery)->draft()->count(),
            'total_views' => (clone $publicationsQuery)->sum('views_count'),
        ];

        // Ajouter les stats globales seulement pour les admins
        if ($isAdmin) {
            $stats['total_users'] = User::count();
            $stats['total_rubriques'] = Rubrique::active()->count();
        }

        // Publications récentes
        $recentPublications = (clone $publicationsQuery)
            ->with(['user', 'rubrique'])
            ->latest()
            ->take(5)
            ->get();

        // Rubriques les plus populaires (toujours global)
        $popularRubriques = Rubrique::orderByDesc('views_count')
            ->take(5)
            ->get();

        // Articles les plus vus
        $popularArticles = (clone $publicationsQuery)
            ->published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // Vues des 7 derniers jours
        $viewsQuery = PublicationView::select(
                DB::raw('DATE(viewed_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('viewed_at', '>=', now()->subDays(7));

        // Filtrer par publications de l'utilisateur si non admin
        if (!$isAdmin) {
            $viewsQuery->whereIn('publication_id', function($query) use ($user) {
                $query->select('id')
                    ->from('publications')
                    ->where('user_id', $user->id);
            });
        }

        $viewsLast7Days = $viewsQuery
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Publications par type
        $publicationsByType = (clone $publicationsQuery)
            ->select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type');

        // Auteurs les plus actifs
        if ($isAdmin) {
            $topAuthors = User::withCount('publications')
                ->having('publications_count', '>', 0)
                ->orderByDesc('publications_count')
                ->take(5)
                ->get();
        } else {
            // Pour les non-admins, on peut soit cacher cette section, soit afficher uniquement l'utilisateur
            $topAuthors = collect([$user->loadCount('publications')]);
        }

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
