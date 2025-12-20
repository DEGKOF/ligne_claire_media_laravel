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

        // Si l'utilisateur n'est pas admin ou master_admin,
        // afficher seulement ses propres publications
        if (!$this->isAdminOrMaster()) {
            $query->where('user_id', auth()->id());
        }

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
            // 'featured_image' => 'nullable|image|max:2048',
            'featured_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,wmv|max:51200',
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
        // Vérifier les permissions
        $this->authorizeEdit($publication);

        $rubriques = Rubrique::active()->ordered()->get();
        $canEdit = $this->canEditPublication($publication);

        return view('admin.publications.edit', compact('publication', 'rubriques', 'canEdit'));
    }

    /**
     * Mettre à jour une publication
     */
    public function update(Request $request, Publication $publication)
    {
        // Vérifier les permissions
        $this->authorizeEdit($publication);

        // CORRECTION : Forcer is_featured et is_breaking à false si non cochés
        $request->merge([
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
        ]);

        $validated = $request->validate([
            'rubrique_id' => 'required|exists:rubriques,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:article,direct,rediffusion,video_courte,lien_externe',
            // 'featured_image' => 'nullable|image|max:2048',
            'featured_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,wmv|max:51200',
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

        // dd($validated);
        $publication->update($validated);

        return redirect()->route('admin.publications.edit', $publication)
            ->with('success', 'Publication mise à jour avec succès !');
    }

    /**
     * Supprimer une publication
     */
    public function destroy(Publication $publication)
    {
        // Vérifier les permissions
        $this->authorizeEdit($publication);

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
        // Vérifier les permissions
        $this->authorizeEdit($publication);

        $publication->publish();
        return back()->with('success', 'Article publié !');
    }

    public function quickUnpublish(Publication $publication)
    {
        // Vérifier les permissions
        $this->authorizeEdit($publication);

        $publication->unpublish();
        return back()->with('success', 'Article masqué !');
    }

    /**
     * Vérifier si l'utilisateur est admin ou master_admin
     */
    private function isAdminOrMaster(): bool
    {
        $role = auth()->user()->role;
        return in_array($role, ['admin', 'master_admin']);
    }

    /**
     * Vérifier si l'utilisateur peut éditer cette publication
     */
    private function canEditPublication(Publication $publication): bool
    {
        // Admin et master_admin peuvent tout modifier
        if ($this->isAdminOrMaster()) {
            return true;
        }

        // Les autres ne peuvent modifier que leurs propres publications
        return $publication->user_id === auth()->id();
    }

    /**
     * Autoriser l'édition ou retourner une erreur 403
     */
    private function authorizeEdit(Publication $publication): void
    {
        if (!$this->canEditPublication($publication)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette publication.');
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:15360', // 5MB max
        ]);

        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Stocker dans public/storage/publications/content
            $path = $image->storeAs('publications/content', $filename, 'public');

            $url = asset('storage/' . $path);

            // Format de réponse pour CKEditor
            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Échec de l\'upload de l\'image'
            ]
        ], 400);
    }
}
