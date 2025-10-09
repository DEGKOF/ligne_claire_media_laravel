<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rubrique;
use Illuminate\Http\Request;

class RubriqueController extends Controller
{
    /**
     * Liste des rubriques
     */
    public function index()
    {
        $rubriques = Rubrique::withCount('publications')
            ->ordered()
            ->get();

        return view('admin.rubriques.index', compact('rubriques'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.rubriques.create');
    }

    /**
     * Enregistrer une nouvelle rubrique
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rubriques,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:7',
        ]);

        $rubrique = Rubrique::create($validated);

        return redirect()->route('admin.rubriques.index')
            ->with('success', 'Rubrique créée avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Rubrique $rubrique)
    {
        return view('admin.rubriques.edit', compact('rubrique'));
    }

    /**
     * Mettre à jour une rubrique
     */
    public function update(Request $request, Rubrique $rubrique)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rubriques,name,' . $rubrique->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:7',
        ]);

        $rubrique->update($validated);

        return redirect()->route('admin.rubriques.index')
            ->with('success', 'Rubrique mise à jour avec succès !');
    }

    /**
     * Supprimer une rubrique
     */
    public function destroy(Rubrique $rubrique)
    {
        // Vérifier s'il y a des publications associées
        if ($rubrique->publications()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette rubrique car elle contient des publications.');
        }

        $rubrique->delete();

        return redirect()->route('admin.rubriques.index')
            ->with('success', 'Rubrique supprimée avec succès !');
    }

    /**
     * Activer/Désactiver une rubrique
     */
    public function toggleActive(Rubrique $rubrique)
    {
        $rubrique->update(['is_active' => !$rubrique->is_active]);

        $status = $rubrique->is_active ? 'activée' : 'désactivée';
        return back()->with('success', "Rubrique {$status} !");
    }

    /**
     * Réorganiser les rubriques (AJAX)
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'rubriques' => 'required|array',
            'rubriques.*.id' => 'required|exists:rubriques,id',
            'rubriques.*.order' => 'required|integer',
        ]);

        foreach ($validated['rubriques'] as $data) {
            Rubrique::where('id', $data['id'])
                ->update(['order' => $data['order']]);
        }

        return response()->json(['success' => true]);
    }
}
