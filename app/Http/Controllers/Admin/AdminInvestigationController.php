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
     * Afficher la liste des propositions d'investigation (API)
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
    }

    /**
     * Afficher la liste des propositions d'investigation (View)
     */
    public function index(Request $request)
    {
        return view('admin.investigation.index');
    }

    /**
     * Afficher les détails d'une proposition
     */
    public function show(InvestigationProposal $proposal)
    {
        $proposal->load(['user', 'validator']);

        return response()->json([
            'success' => true,
            'proposal' => $proposal
        ]);
    }

    /**
     * Télécharger un fichier
     */
    public function downloadFile(Request $request)
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
            $filePath = $request->file_path;

            if (!Storage::disk('public')->exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier non trouvé'
                ], 404);
            }

            return Storage::disk('public')->download($filePath);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement'
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
}
