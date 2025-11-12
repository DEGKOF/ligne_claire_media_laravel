<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\AdvertisementPlacement;
use App\Models\AdvertiserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertiserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Dashboard annonceur
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Créer le profil si inexistant
        if (!$user->advertiserProfile) {
            $user->createProfile();
        }

        $profile = $user->advertiserProfile;
        // dd($profile);
        // Stats
        $stats = [
            'total_campaigns' => $user->advertisements()->count(),
            'active_campaigns' => $user->advertisements()->active()->count(),
            'pending_campaigns' => $user->advertisements()->pending()->count(),
            'balance' => $profile->balance ?? 0,
            'total_impressions' => $user->advertisements()->sum('impressions_count'),
            'total_clicks' => $user->advertisements()->sum('clicks_count'),
            'total_spent' => $user->advertisements()->sum('spent'),
        ];

        // Campagnes récentes
        $recentCampaigns = $user->advertisements()
            ->with('placement')
            ->latest()
            ->take(5)
            ->get();

        return view('advertiser.dashboard', compact('profile', 'stats', 'recentCampaigns'));
    }

    /**
     * Compléter le profil
     */
    public function completeProfile()
    {
        $profile = auth()->user()->advertiserProfile;
        $profileStatus = 'En attente';
dd($profile);
        if ($profile->status !== 'pending') {
            // return redirect()->route('advertiser.dashboard')
            //     ->with('info', 'Votre profil a déjà été traité.');
            $profileStatus = 'Validé';
        }

        return view('advertiser.profile.complete', compact('profile', 'profileStatus'));
    }

    /**
     * Enregistrer le profil
     */
    public function storeProfile(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'legal_form' => 'nullable|string|max:50',
            'rccm' => 'nullable|string|max:100',
            'ifu' => 'nullable|string|max:100',
            'sector' => 'nullable|string|max:100',
            'employees_count' => 'nullable|integer|min:0',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email',
            'contact_position' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'company_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'id_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $profile = auth()->user()->advertiserProfile;

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('advertisers/logos', 'public');
        }

        // Upload documents
        if ($request->hasFile('company_document')) {
            if ($profile->company_document) {
                Storage::disk('public')->delete($profile->company_document);
            }
            $validated['company_document'] = $request->file('company_document')
                ->store('advertisers/documents', 'public');
        }

        if ($request->hasFile('id_document')) {
            if ($profile->id_document) {
                Storage::disk('public')->delete($profile->id_document);
            }
            $validated['id_document'] = $request->file('id_document')
                ->store('advertisers/documents', 'public');
        }

        $profile->update($validated);

        return redirect()->route('advertiser.dashboard')
            ->with('success', 'Profil enregistré ! En attente de validation.');
    }

    /**
     * Liste des campagnes
     */
    public function campaigns(Request $request)
    {
        $query = auth()->user()->advertisements()->with('placement');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%');
            });
        }

        $campaigns = $query->latest()->paginate(15);

        return view('advertiser.campaigns.index', compact('campaigns'));
    }

    /**
     * Créer une campagne
     */
    public function createCampaign()
    {
        $profile = auth()->user()->advertiserProfile;

        if (!$profile->isActive()) {
            return redirect()->route('advertiser.dashboard')
                ->with('error', 'Votre profil doit être validé avant de créer une campagne.');
        }

        $placements = AdvertisementPlacement::active()->ordered()->get();

        return view('advertiser.campaigns.create', compact('placements'));
    }

    /**
     * Enregistrer une campagne
     */
    public function storeCampaign(Request $request)
    {
        $validated = $request->validate([
            'placement_id' => 'required|exists:advertisement_placements,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:image,video,html',
            'image' => 'required_if:content_type,image|nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'video_url' => 'required_if:content_type,video|nullable|url',
            'html_content' => 'required_if:content_type,html|nullable|string',
            'headline' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'cta_text' => 'nullable|string|max:50',
            'target_url' => 'required|url',
            'open_new_tab' => 'boolean',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'daily_budget' => 'nullable|numeric|min:0',
            'target_rubriques' => 'nullable|array',
            'target_pages' => 'nullable|array',
            'target_devices' => 'nullable|array',
            // 'video_url' => 'nullable|url',
            // 'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:51200', // 50MB

            'video_url' => 'nullable|required_without:video_file|url',
            'video_file' => 'nullable|required_without:video_url|file|mimes:mp4,webm,ogg|max:51200',
        ]);

        $validated['advertiser_id'] = auth()->id();
        $validated['status'] = 'draft';

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('advertisements', 'public');
        }

        // Upload vidéo - LOGIQUE EXCLUSIVE
        if ($request->hasFile('video_file')) {
            $validated['video_path'] = $request->file('video_file')
                ->store('advertisements/videos', 'public');
            $validated['video_url'] = null; // Annuler l'URL si fichier fourni
        } elseif ($request->filled('video_url')) {
            $validated['video_path'] = null; // Pas de fichier si URL
        }

        $campaign = Advertisement::create($validated);

        return redirect()->route('advertiser.campaigns.edit', $campaign)
            ->with('success', 'Campagne créée ! Complétez et soumettez pour validation.');
    }

    /**
     * Éditer une campagne
     */
    public function editCampaign(Advertisement $campaign)
    {
        $this->authorize('update', $campaign);

        $placements = AdvertisementPlacement::active()->ordered()->get();

        return view('advertiser.campaigns.edit', compact('campaign', 'placements'));
    }

    /**
     * Mettre à jour une campagne
     */
    public function updateCampaign(Request $request, Advertisement $campaign)
    {
        $this->authorize('update', $campaign);

        if (!in_array($campaign->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Seules les campagnes en brouillon ou rejetées peuvent être modifiées.');
        }

        $validated = $request->validate([
            'placement_id' => 'required|exists:advertisement_placements,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:image,video,html',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'video_url' => 'required_if:content_type,video|nullable|url',
            'html_content' => 'required_if:content_type,html|nullable|string',
            'headline' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'cta_text' => 'nullable|string|max:50',
            'target_url' => 'required|url',
            'open_new_tab' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'daily_budget' => 'nullable|numeric|min:0',
            'target_rubriques' => 'nullable|array',
            'target_pages' => 'nullable|array',
            'target_devices' => 'nullable|array',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            if ($campaign->image_path) {
                Storage::disk('public')->delete($campaign->image_path);
            }
            $validated['image_path'] = $request->file('image')
                ->store('advertisements', 'public');
        }

        // Upload vidéo
        if ($request->hasFile('video_file')) {
            if ($campaign->video_path) {
                Storage::disk('public')->delete($campaign->video_path);
            }
            $validated['video_path'] = $request->file('video_file')
                ->store('advertisements/videos', 'public');
            $validated['video_url'] = null;
        } elseif ($request->filled('video_url')) {
            // Si URL fournie, effacer le fichier existant
            if ($campaign->video_path) {
                Storage::disk('public')->delete($campaign->video_path);
            }
            $validated['video_path'] = null;
        }

        $campaign->update($validated);

        return redirect()->route('advertiser.campaigns.show', $campaign)
            ->with('success', 'Campagne mise à jour !');
    }

    /**
     * Voir une campagne
     */
    public function showCampaign(Advertisement $campaign)
    {
        $this->authorize('view', $campaign);

        // Stats détaillées
        $dailyStats = $campaign->impressions()
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('advertiser.campaigns.show', compact('campaign', 'dailyStats'));
    }

    /**
     * Soumettre une campagne
     */
    public function submitCampaign(Advertisement $campaign)
    {
        $this->authorize('update', $campaign);

        if ($campaign->status !== 'draft') {
            return back()->with('error', 'Seules les campagnes en brouillon peuvent être soumises.');
        }

        $campaign->submit();

        return redirect()->route('advertiser.campaigns.show', $campaign)
            ->with('success', 'Campagne soumise pour validation !');
    }

    /**
     * Mettre en pause une campagne
     */
    public function pauseCampaign(Advertisement $campaign)
    {
        $this->authorize('update', $campaign);

        try {
            $campaign->pause();
            return back()->with('success', 'Campagne mise en pause.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reprendre une campagne
     */
    public function resumeCampaign(Advertisement $campaign)
    {
        $this->authorize('update', $campaign);

        try {
            $campaign->resume();
            return back()->with('success', 'Campagne reprise.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Supprimer une campagne
     */
    public function destroyCampaign(Advertisement $campaign)
    {
        $this->authorize('delete', $campaign);

        if (!in_array($campaign->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Seules les campagnes en brouillon ou rejetées peuvent être supprimées.');
        }

        if ($campaign->image_path) {
            Storage::disk('public')->delete($campaign->image_path);
        }

        $campaign->delete();

        return redirect()->route('advertiser.campaigns.index')
            ->with('success', 'Campagne supprimée.');
    }
}
