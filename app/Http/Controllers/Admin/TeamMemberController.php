<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamMemberController extends Controller
{
    /**
     * Liste des membres
     */
    public function index(Request $request)
    {
        $query = TeamMember::query()->ordered();

        // Filtre par visibilité
        if ($request->has('visibility')) {
            if ($request->visibility === 'visible') {
                $query->where('is_visible', true);
            } elseif ($request->visibility === 'hidden') {
                $query->where('is_visible', false);
            }
        }

        // Recherche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('poste', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(15);

        return view('admin.team.index', compact('members'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Enregistrer un nouveau membre
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'ordre' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ], [
            'nom.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'poste.required' => 'Le poste est requis.',
            'email.email' => 'L\'email doit être valide.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('photo');
        $data['is_visible'] = $request->has('is_visible');

        // Upload photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre ajouté avec succès.');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team.edit', compact('teamMember'));
    }

    /**
     * Mettre à jour un membre
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'ordre' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('photo');
        $data['is_visible'] = $request->has('is_visible');

        // Upload nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($teamMember->photo) {
                Storage::delete($teamMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre modifié avec succès.');
    }

    /**
     * Supprimer un membre
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre supprimé avec succès.');
    }

    /**
     * Toggle visibilité
     */
    public function toggleVisibility(TeamMember $teamMember)
    {
        $teamMember->update([
            'is_visible' => !$teamMember->is_visible
        ]);

        $status = $teamMember->is_visible ? 'visible' : 'masqué';

        return redirect()->route('admin.team.index')
            ->with('success', "Le membre est maintenant {$status}.");
    }

    /**
     * Supprimer la photo
     */
    public function deletePhoto(TeamMember $teamMember)
    {
        if ($teamMember->photo) {
            Storage::delete($teamMember->photo);
            $teamMember->update(['photo' => null]);
        }

        return redirect()->back()
            ->with('success', 'Photo supprimée avec succès.');
    }
}
