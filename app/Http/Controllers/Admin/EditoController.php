<?php

namespace App\Http\Controllers\Admin;

use App\Models\Edito;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditoController extends Controller
{
    /**
     * Afficher la liste des éditos
     */
    public function index()
    {
        $editos = Edito::withTrashed()
            ->with('user')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.editos.index', compact('editos'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.editos.create');
    }

    /**
     * Enregistrer un nouvel édito
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'title.required' => 'Le titre est requis',
            'content.required' => 'Le contenu est requis',
            'status.required' => 'Le statut est requis',
            'cover_image.image' => 'Le fichier doit être une image',
            'cover_image.max' => 'L\'image ne doit pas dépasser 5MB',
        ]);

        // Associer l'utilisateur connecté
        $validated['user_id'] = auth()->id();

        // Gestion de l'upload de l'image de couverture
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('editos/covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        // Si publié sans date, mettre la date actuelle
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $edito = Edito::create($validated);

        return redirect()
            ->route('admin.editos.index')
            ->with('success', 'Édito créé avec succès');
    }

    /**
     * Afficher le détail d'un édito (preview)
     */
    public function show(Edito $edito)
    {
        $edito->load('user');
        return view('admin.editos.show', compact('edito'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Edito $edito)
    {
        return view('admin.editos.edit', compact('edito'));
    }

    /**
     * Mettre à jour un édito
     */
    public function update(Request $request, Edito $edito)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Gestion de la nouvelle image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image
            if ($edito->cover_image) {
                Storage::disk('public')->delete($edito->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('editos/covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        // Régénérer le slug si le titre change
        if ($edito->title !== $validated['title']) {
            $validated['slug'] = Edito::generateUniqueSlug($validated['title']);
        }

        $edito->update($validated);

        return redirect()
            ->route('admin.editos.index')
            ->with('success', 'Édito mis à jour avec succès');
    }

    /**
     * Supprimer un édito (soft delete)
     */
    public function destroy(Edito $edito)
    {
        $edito->delete();

        return redirect()
            ->route('admin.editos.index')
            ->with('success', 'Édito archivé avec succès');
    }

    /**
     * Restaurer un édito supprimé
     */
    public function restore($id)
    {
        $edito = Edito::withTrashed()->findOrFail($id);
        $edito->restore();

        return redirect()
            ->route('admin.editos.index')
            ->with('success', 'Édito restauré avec succès');
    }

    /**
     * Supprimer définitivement un édito
     */
    public function forceDelete($id)
    {
        $edito = Edito::withTrashed()->findOrFail($id);

        // Supprimer les fichiers physiques
        if ($edito->cover_image) {
            Storage::disk('public')->delete($edito->cover_image);
        }

        $edito->forceDelete();

        return redirect()
            ->route('admin.editos.index')
            ->with('success', 'Édito supprimé définitivement');
    }

    /**
     * Changer rapidement le statut
     */
    public function updateStatus(Request $request, Edito $edito)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);

        $edito->update($validated);

        return back()->with('success', 'Statut mis à jour');
    }
}
