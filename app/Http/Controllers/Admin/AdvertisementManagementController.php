<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementPlacement;
use Illuminate\Http\Request;

class AdvertisementManagementController extends Controller
{
    /**
     * Liste des campagnes
     */
    public function index(Request $request)
    {
        $query = Advertisement::with(['advertiser', 'placement']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('placement_id')) {
            $query->where('placement_id', $request->placement_id);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%')
                  ->orWhereHas('advertiser', function($sq) use ($request) {
                      $sq->where('company_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $campaigns = $query->latest()->paginate(20);
        $placements = AdvertisementPlacement::active()->get();

        $stats = [
            'pending' => Advertisement::pending()->count(),
            'active' => Advertisement::active()->count(),
            'total_impressions' => Advertisement::sum('impressions_count'),
            'total_clicks' => Advertisement::sum('clicks_count'),
        ];

        return view('admin.advertisements.index', compact('campaigns', 'placements', 'stats'));
    }

    /**
     * Voir une campagne
     */
    public function show(Advertisement $campaign)
    {
        $campaign->load(['advertiser.advertiserProfile', 'placement', 'approver']);

        // Stats
        $dailyStats = $campaign->impressions()
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as impressions')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.advertisements.show', compact('campaign', 'dailyStats'));
    }

    /**
     * Approuver une campagne
     */
    public function approve(Advertisement $campaign)
    {
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Seules les campagnes en attente peuvent être approuvées.');
        }

        $campaign->approve(auth()->user());

        return back()->with('success', 'Campagne approuvée !');
    }

    /**
     * Rejeter une campagne
     */
    public function reject(Request $request, Advertisement $campaign)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Seules les campagnes en attente peuvent être rejetées.');
        }

        $campaign->reject($validated['reason'], auth()->user());

        return back()->with('success', 'Campagne rejetée.');
    }

    /**
     * Activer une campagne
     */
    public function activate(Advertisement $campaign)
    {
        try {
            $campaign->activate();
            return back()->with('success', 'Campagne activée !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mettre en pause
     */
    public function pause(Advertisement $campaign)
    {
        try {
            $campaign->pause();
            return back()->with('success', 'Campagne mise en pause.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Gestion des emplacements
     */
    public function placementsIndex()
    {
        $placements = AdvertisementPlacement::withCount('advertisements')->get();

        return view('admin.advertisements.placements.index', compact('placements'));
    }

    public function placementsCreate()
    {
        return view('admin.advertisements.placements.create');
    }

    public function placementsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:advertisement_placements,code',
            'description' => 'nullable|string',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'price_per_day' => 'required|numeric|min:0',
            'billing_type' => 'required|in:flat,cpm,cpc',
            'is_active' => 'boolean',
        ]);

        AdvertisementPlacement::create($validated);

        return redirect()->route('admin.advertisements.placements.index')
            ->with('success', 'Emplacement créé !');
    }
}
