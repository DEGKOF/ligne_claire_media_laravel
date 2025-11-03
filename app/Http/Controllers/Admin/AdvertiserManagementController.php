<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvertiserProfile;
use Illuminate\Http\Request;

class AdvertiserManagementController extends Controller
{
    /**
     * Liste des profils annonceurs
     */
    public function index(Request $request)
    {
        $query = AdvertiserProfile::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $profiles = $query->latest()->paginate(20);

        $stats = [
            'pending' => AdvertiserProfile::pending()->count(),
            'active' => AdvertiserProfile::active()->count(),
            'suspended' => AdvertiserProfile::suspended()->count(),
            'rejected' => AdvertiserProfile::rejected()->count(),
        ];

        return view('admin.advertisers.index', compact('profiles', 'stats'));
    }

    /**
     * Voir un profil
     */
    public function show(AdvertiserProfile $profile)
    {
        $profile->load(['user', 'advertisements' => function($q) {
            $q->latest()->take(10);
        }]);

        return view('admin.advertisers.show', compact('profile'));
    }

    /**
     * Approuver un profil
     */
    public function approve(AdvertiserProfile $profile)
    {
        if ($profile->status !== 'pending') {
            return back()->with('error', 'Seuls les profils en attente peuvent être approuvés.');
        }

        $profile->approve(auth()->user());

        return back()->with('success', 'Profil annonceur approuvé !');
    }

    /**
     * Rejeter un profil
     */
    public function reject(Request $request, AdvertiserProfile $profile)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($profile->status !== 'pending') {
            return back()->with('error', 'Seuls les profils en attente peuvent être rejetés.');
        }

        $profile->reject($validated['reason'], auth()->user());

        return back()->with('success', 'Profil annonceur rejeté.');
    }

    /**
     * Suspendre un profil
     */
    public function suspend(Request $request, AdvertiserProfile $profile)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($profile->status !== 'active') {
            return back()->with('error', 'Seuls les profils actifs peuvent être suspendus.');
        }

        $profile->suspend($validated['reason']);

        return back()->with('success', 'Profil annonceur suspendu.');
    }

    /**
     * Réactiver un profil
     */
    public function reactivate(AdvertiserProfile $profile)
    {
        if ($profile->status !== 'suspended') {
            return back()->with('error', 'Seuls les profils suspendus peuvent être réactivés.');
        }

        $profile->reactivate();

        return back()->with('success', 'Profil annonceur réactivé.');
    }
}
