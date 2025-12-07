<?php

namespace App\Http\Controllers\Admin;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IssueController extends Controller
{
    /**
     * Afficher la liste des journaux
     */
    public function index()
    {
        $issues = Issue::withTrashed()
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        return view('admin.issues.index', compact('issues'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.issues.create');
    }

    /**
     * Enregistrer un nouveau journal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'required|date',
            'price' => 'required|numeric|min:0',
            'digital_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf_file' => 'nullable|mimes:pdf|max:51200', // Max 50MB
        ], [
            'title.required' => 'Le titre est requis',
            'published_at.required' => 'La date de publication est requise',
            'cover_image.image' => 'Le fichier doit être une image',
            'cover_image.max' => 'L\'image ne doit pas dépasser 5MB',
            'pdf_file.mimes' => 'Le fichier doit être au format PDF',
            'pdf_file.max' => 'Le PDF ne doit pas dépasser 50MB',
        ]);

        // Gestion de l'upload de l'image de couverture
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('issues/covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        // Gestion de l'upload du PDF
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('issues/pdfs', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        Issue::create($validated);

        return redirect()
            ->route('admin.issues.index')
            ->with('success', 'Journal créé avec succès');
    }

    /**
     * Afficher le détail d'un journal (preview)
     */
    public function show(Issue $issue)
    {
        return view('admin.issues.show', compact('issue'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Issue $issue)
    {
        return view('admin.issues.edit', compact('issue'));
    }

    /**
     * Mettre à jour un journal
     */
    public function update(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'required|date',
            'price' => 'required|numeric|min:0',
            'digital_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf_file' => 'nullable|mimes:pdf|max:51200',
        ]);

        // Gestion de la nouvelle image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image
            if ($issue->cover_image) {
                Storage::disk('public')->delete($issue->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('issues/covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        // Gestion du nouveau PDF
        if ($request->hasFile('pdf_file')) {
            // Supprimer l'ancien PDF
            if ($issue->pdf_file) {
                Storage::disk('public')->delete($issue->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('issues/pdfs', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        $issue->update($validated);

        return redirect()
            ->route('admin.issues.index')
            ->with('success', 'Journal mis à jour avec succès');
    }

    /**
     * Supprimer un journal (soft delete)
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()
            ->route('admin.issues.index')
            ->with('success', 'Journal archivé avec succès');
    }

    /**
     * Restaurer un journal supprimé
     */
    public function restore($id)
    {
        $issue = Issue::withTrashed()->findOrFail($id);
        $issue->restore();

        return redirect()
            ->route('admin.issues.index')
            ->with('success', 'Journal restauré avec succès');
    }

    /**
     * Supprimer définitivement un journal
     */
    public function forceDelete($id)
    {
        $issue = Issue::withTrashed()->findOrFail($id);

        // Supprimer les fichiers physiques
        if ($issue->cover_image) {
            Storage::disk('public')->delete($issue->cover_image);
        }
        if ($issue->pdf_file) {
            Storage::disk('public')->delete($issue->pdf_file);
        }

        $issue->forceDelete();

        return redirect()
            ->route('admin.issues.index')
            ->with('success', 'Journal supprimé définitivement');
    }

    /**
     * Changer rapidement le statut
     */
    public function updateStatus(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);

        $issue->update($validated);

        return back()->with('success', 'Statut mis à jour');
    }
}
