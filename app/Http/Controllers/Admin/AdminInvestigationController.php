<?php

namespace App\Http\Controllers\Admin;

use App\Models\Publication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InvestigationProposal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminInvestigationController extends Controller
{
    /**
     * Afficher la liste des propositions d'investigation
     */
    public function indexApi(Request $request)
    {
        $query = InvestigationProposal::with(['user', 'validator']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('theme')) {
            $query->where('theme', $request->theme);
        }

        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('angle', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $proposals = $query->paginate($request->get('per_page', 20));

        // Statistiques
        $stats = [
            'total' => InvestigationProposal::count(),
            'pending' => InvestigationProposal::pending()->count(),
            'validated' => InvestigationProposal::validated()->count(),
            'in_progress' => InvestigationProposal::inProgress()->count(),
            'completed' => InvestigationProposal::completed()->count(),
            'rejected' => InvestigationProposal::rejected()->count(),
            'total_budget' => InvestigationProposal::sum('budget'),
            'total_collected' => InvestigationProposal::sum('budget_collected'),
        ];

        return response()->json([
            'success' => true,
            'proposals' => $proposals,
            'stats' => $stats
        ]);

        dd($stats);

        // return view('admin.investigation.index', compact('proposals', 'stats'));
    }
    public function index(Request $request)
    {
        $query = InvestigationProposal::with(['user', 'validator']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('theme')) {
            $query->where('theme', $request->theme);
        }

        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('angle', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $proposals = $query->paginate($request->get('per_page', 20));

        // Statistiques
        $stats = [
            'total' => InvestigationProposal::count(),
            'pending' => InvestigationProposal::pending()->count(),
            'validated' => InvestigationProposal::validated()->count(),
            'in_progress' => InvestigationProposal::inProgress()->count(),
            'completed' => InvestigationProposal::completed()->count(),
            'rejected' => InvestigationProposal::rejected()->count(),
            'total_budget' => InvestigationProposal::sum('budget'),
            'total_collected' => InvestigationProposal::sum('budget_collected'),
        ];

        // return response()->json([
        //     'success' => true,
        //     'proposals' => $proposals,
        //     'stats' => $stats
        // ]);

        // dd($stats);

        return view('admin.investigation.index', compact('proposals', 'stats'));
    }

    /**
     * Afficher les détails d'une proposition
     */
    public function investigations(InvestigationProposal $proposal)
    {
        $proposal->load(['user', 'validator']);

        return response()->json([
            'success' => true,
            'proposal' => $proposal
        ]);
    }

    /**
     * Mettre à jour le contenu d'une proposition
     */
    public function update(Request $request, InvestigationProposal $proposal)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|min:10|max:140',
            'theme' => 'sometimes|string',
            'angle' => 'sometimes|string|min:30|max:1200',
            'sources' => 'sometimes|string|max:1600',
            'format' => 'sometimes|string|in:Article long,Vidéo,Podcast,Infographie,Série multimédia',
            'budget' => 'sometimes|numeric|min:0|max:999999999',
            'estimated_weeks' => 'sometimes|integer|min:1|max:52',
            'needs' => 'sometimes|string|max:1000',
            'budget_collected' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only([
                'title', 'theme', 'angle', 'sources', 'format',
                'budget', 'estimated_weeks', 'needs', 'budget_collected'
            ]);

            // Gérer l'upload de nouveaux fichiers
            if ($request->hasFile('files')) {
                $files = $proposal->files ?? [];
                foreach ($request->file('files') as $file) {
                    $path = $file->store('investigation/proposals', 'public');
                    $files[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType(),
                    ];
                }
                $data['files'] = $files;
            }

            $proposal->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Proposition mise à jour avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Valider une proposition
     */
    public function validateInvestigation(InvestigationProposal $proposal)
    {
        if ($proposal->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les propositions en attente peuvent être validées'
            ], 400);
        }

        try {
            $proposal->validate(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Proposition validée avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation'
            ], 500);
        }
    }

    /**
     * Rejeter une proposition
     */
    public function rejectInvestigation(Request $request, InvestigationProposal $proposal)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $proposal->reject($request->rejection_reason);
            $proposal->update(['validated_by' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Proposition rejetée avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet'
            ], 500);
        }
    }

    /**
     * Démarrer une investigation
     */
    public function startInvestigation(InvestigationProposal $proposal)
    {
        if ($proposal->status !== 'validated') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les propositions validées peuvent être démarrées'
            ], 400);
        }

        try {
            $proposal->startInvestigation();

            return response()->json([
                'success' => true,
                'message' => 'Investigation démarrée avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du démarrage'
            ], 500);
        }
    }

    /**
     * Marquer une investigation comme terminée
     */
    public function complete(InvestigationProposal $proposal)
    {
        if ($proposal->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les investigations en cours peuvent être terminées'
            ], 400);
        }

        try {
            $proposal->complete();

            return response()->json([
                'success' => true,
                'message' => 'Investigation marquée comme terminée',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la finalisation'
            ], 500);
        }
    }

    /**
     * Mettre à jour le statut d'une proposition
     */
    public function updateStatus(Request $request, InvestigationProposal $proposal)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,validated,rejected,in_progress,completed',
            'rejection_reason' => 'required_if:status,rejected|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $status = $request->status;

            switch ($status) {
                case 'validated':
                    $proposal->validate(Auth::id());
                    break;
                case 'rejected':
                    $proposal->reject($request->rejection_reason);
                    $proposal->update(['validated_by' => Auth::id()]);
                    break;
                case 'in_progress':
                    $proposal->startInvestigation();
                    break;
                case 'completed':
                    $proposal->complete();
                    break;
                case 'pending':
                    $proposal->update([
                        'status' => 'pending',
                        'rejection_reason' => null,
                        'validated_at' => null,
                        'validated_by' => null,
                        'started_at' => null,
                        'completed_at' => null,
                    ]);
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }
    }

    /**
     * Supprimer un fichier attaché
     */
    public function deleteFile(Request $request, InvestigationProposal $proposal)
    {
        $validator = Validator::make($request->all(), [
            'file_path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $files = $proposal->files ?? [];
            $filePath = $request->file_path;

            $files = array_filter($files, function($file) use ($filePath) {
                return $file['path'] !== $filePath;
            });

            // Supprimer le fichier du storage
            Storage::disk('public')->delete($filePath);

            $proposal->update(['files' => array_values($files)]);

            return response()->json([
                'success' => true,
                'message' => 'Fichier supprimé avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du fichier'
            ], 500);
        }
    }

    /**
     * Supprimer une proposition (soft delete)
     */
    public function destroy(InvestigationProposal $proposal)
    {
        try {
            $proposal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proposition supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }
    }

    /**
     * Restaurer une proposition supprimée
     */
    public function restore($id)
    {
        try {
            $proposal = InvestigationProposal::withTrashed()->findOrFail($id);
            $proposal->restore();

            return response()->json([
                'success' => true,
                'message' => 'Proposition restaurée avec succès',
                'proposal' => $proposal->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration'
            ], 500);
        }
    }

    /**
     * Actions en masse
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:validate,reject,start,complete,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:investigation_proposals,id',
            'rejection_reason' => 'required_if:action,reject|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $proposals = InvestigationProposal::whereIn('id', $request->ids)->get();
            $action = $request->action;
            $count = 0;

            foreach ($proposals as $proposal) {
                switch ($action) {
                    case 'validate':
                        if ($proposal->status === 'pending') {
                            $proposal->validate(Auth::id());
                            $count++;
                        }
                        break;
                    case 'reject':
                        if ($proposal->status === 'pending') {
                            $proposal->reject($request->rejection_reason);
                            $proposal->update(['validated_by' => Auth::id()]);
                            $count++;
                        }
                        break;
                    case 'start':
                        if ($proposal->status === 'validated') {
                            $proposal->startInvestigation();
                            $count++;
                        }
                        break;
                    case 'complete':
                        if ($proposal->status === 'in_progress') {
                            $proposal->complete();
                            $count++;
                        }
                        break;
                    case 'delete':
                        $proposal->delete();
                        $count++;
                        break;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "{$count} proposition(s) traitée(s) avec succès",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement en masse'
            ], 500);
        }
    }

    // public function investigations(InvestigationProposal $proposal)
    // {
    //     // Charger les relations nécessaires
    //     $proposal->load('user', 'validator');

    //     // Vérifier que la proposition est visible (validée, en cours ou terminée)
    //     if (!in_array($proposal->status, ['validated', 'in_progress', 'completed'])) {
    //         abort(404);
    //     }

    //     // Récupérer les breaking news pour la sidebar
    //     $breakingNews = Publication::published()
    //         ->breaking()
    //         ->latest('published_at')
    //         ->take(5)
    //         ->get();

    //     return view('investigation.show', compact('proposal', 'breakingNews'));
    // }
}
