<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCandidatureController extends Controller
{
    /**
     * Afficher la liste des candidatures
     */
    public function index(Request $request)
    {
        $query = Candidature::query()->orderBy('created_at', 'desc');

        // Filtrer par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrer par poste
        if ($request->filled('poste')) {
            $query->where('poste', $request->poste);
        }

        // Recherche par nom, prénom ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrer par date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $candidatures = $query->paginate(20);

        // Statistiques
        $stats = [
            'total' => Candidature::count(),
            'en_attente' => Candidature::where('statut', 'en_attente')->count(),
            'examinee' => Candidature::where('statut', 'examinee')->count(),
            'acceptee' => Candidature::where('statut', 'acceptee')->count(),
            'refusee' => Candidature::where('statut', 'refusee')->count(),
            'journaliste' => Candidature::where('poste', 'journaliste')->count(),
            'redacteur' => Candidature::where('poste', 'redacteur')->count(),
        ];

        return view('admin.candidatures.index', compact('candidatures', 'stats'));
    }

    /**
     * Afficher les détails d'une candidature
     */
    public function show(Candidature $candidature)
    {
        return view('admin.candidatures.show', compact('candidature'));
    }

    /**
     * Mettre à jour le statut d'une candidature
     */
    public function updateStatus(Request $request, Candidature $candidature)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,examinee,acceptee,refusee',
        ]);

        $candidature->update([
            'statut' => $request->statut,
            'date_examen' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Le statut de la candidature a été mis à jour avec succès.');
    }

    /**
     * Ajouter ou mettre à jour les notes admin
     */
    public function updateNotes(Request $request, Candidature $candidature)
    {
        $request->validate([
            'notes_admin' => 'nullable|string|max:5000',
        ]);

        $candidature->update([
            'notes_admin' => $request->notes_admin,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Les notes ont été enregistrées avec succès.');
    }

    /**
     * Télécharger le CV
     */
    public function downloadCv(Candidature $candidature)
    {
        if (!Storage::disk('public')->exists($candidature->cv_path)) {
            abort(404, 'Fichier non trouvé');
        }

        $filename = "CV_{$candidature->prenom}_{$candidature->nom}.pdf";
        return Storage::disk('public')->download($candidature->cv_path, $filename);
    }

    /**
     * Télécharger la lettre de motivation (fichier)
     */
    public function downloadLettre(Candidature $candidature)
    {
        if (!$candidature->lettre_motivation_path || !Storage::disk('public')->exists($candidature->lettre_motivation_path)) {
            abort(404, 'Fichier non trouvé');
        }

        $filename = "Lettre_{$candidature->prenom}_{$candidature->nom}.pdf";
        return Storage::disk('public')->download($candidature->lettre_motivation_path, $filename);
    }

    /**
     * Supprimer une candidature
     */
    public function destroy(Candidature $candidature)
    {
        try {
            // Supprimer les fichiers
            if (Storage::disk('public')->exists($candidature->cv_path)) {
                Storage::disk('public')->delete($candidature->cv_path);
            }
            if ($candidature->lettre_motivation_path && Storage::disk('public')->exists($candidature->lettre_motivation_path)) {
                Storage::disk('public')->delete($candidature->lettre_motivation_path);
            }

            // Supprimer la candidature
            $candidature->delete();

            return redirect()
                ->route('admin.candidatures.index')
                ->with('success', 'La candidature a été supprimée avec succès.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Exporter les candidatures en CSV
     */
    public function export(Request $request)
    {
        $query = Candidature::query()->orderBy('created_at', 'desc');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('poste')) {
            $query->where('poste', $request->poste);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $candidatures = $query->get();

        $filename = 'candidatures_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($candidatures) {
            $file = fopen('php://output', 'w');

            // En-têtes du CSV
            fputcsv($file, [
                'ID',
                'Date',
                'Nom',
                'Prénom',
                'Email',
                'Téléphone',
                'Poste',
                'Statut',
                'Date examen',
            ], ';');

            // Données
            foreach ($candidatures as $candidature) {
                fputcsv($file, [
                    $candidature->id,
                    $candidature->created_at->format('d/m/Y H:i'),
                    $candidature->nom,
                    $candidature->prenom,
                    $candidature->email,
                    $candidature->telephone,
                    $candidature->poste_libelle,
                    $candidature->statut_libelle,
                    $candidature->date_examen ? $candidature->date_examen->format('d/m/Y H:i') : '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
