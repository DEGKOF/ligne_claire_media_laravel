<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Rubrique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    /**
     * Liste des publications
     */
    public function index(Request $request)
    {
        $query = Publication::with(['user', 'rubrique']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('rubrique_id')) {
            $query->where('rubrique_id', $request->rubrique_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $publications = $query->latest()->paginate(20);
        $rubriques = Rubrique::active()->ordered()->get();

        return view('admin.publications.index', compact('publications', 'rubriques'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $rubriques = Rubrique::active()->ordered()->get();
        return view('admin.publications.create', compact('rubriques'));
    }

    /**
     * Enregistrer une nouvelle publication
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rubrique_id' => 'required|exists:rubriques,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:article,direct,rediffusion,video_courte,lien_externe',
            'featured_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'external_link' => 'nullable|url',
            'video_duration' => 'nullable|integer',
            'status' => 'nullable|in:draft,published,hidden',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        // Upload de l'image
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('publications', 'public');
        }

        // Si publié, ajouter la date de publication
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $publication = Publication::create($validated);

        return redirect()->route('admin.publications.edit', $publication)
            ->with('success', 'Publication créée avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Publication $publication)
    {
        $rubriques = Rubrique::active()->ordered()->get();
        return view('admin.publications.edit', compact('publication', 'rubriques'));
    }

    /**
     * Mettre à jour une publication
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'rubrique_id' => 'required|exists:rubriques,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:article,direct,rediffusion,video_courte,lien_externe',
            'featured_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'external_link' => 'nullable|url',
            'video_duration' => 'nullable|integer',
            'status' => 'required|in:draft,published,hidden',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Upload de l'image
        if ($request->hasFile('featured_image')) {
            // Supprimer l'ancienne image
            if ($publication->featured_image) {
                Storage::disk('public')->delete($publication->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('publications', 'public');
        }

        // Si passage de draft à published
        if ($validated['status'] === 'published' && $publication->status !== 'published') {
            $validated['published_at'] = now();
        }

        $publication->update($validated);

        return redirect()->route('admin.publications.edit', $publication)
            ->with('success', 'Publication mise à jour avec succès !');
    }

    /**
     * Supprimer une publication
     */
    public function destroy(Publication $publication)
    {
        if ($publication->featured_image) {
            Storage::disk('public')->delete($publication->featured_image);
        }

        $publication->delete();

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication supprimée avec succès !');
    }

    /**
     * Actions rapides
     */
    public function quickPublish(Publication $publication)
    {
        $publication->publish();
        return back()->with('success', 'Article publié !');
    }

    public function quickUnpublish(Publication $publication)
    {
        $publication->unpublish();
        return back()->with('success', 'Article masqué !');
    }
}
