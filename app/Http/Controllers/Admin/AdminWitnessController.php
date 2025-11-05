<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WitnessTestimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminWitnessController extends Controller
{
    /**
     * Afficher la liste des témoignages
     */
    public function index(Request $request)
    {
        $query = WitnessTestimony::with(['user', 'validator']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('anonymous')) {
            $query->where('anonymous_publication', $request->boolean('anonymous'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
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

        $testimonies = $query->paginate($request->get('per_page', 20));

        // Statistiques
        $stats = [
            'total' => WitnessTestimony::count(),
            'pending' => WitnessTestimony::pending()->count(),
            'validated' => WitnessTestimony::validated()->count(),
            'rejected' => WitnessTestimony::rejected()->count(),
            'published' => WitnessTestimony::published()->count(),
            'anonymous' => WitnessTestimony::anonymous()->count(),
            'total_views' => WitnessTestimony::sum('views'),
        ];

        return response()->json([
            'success' => true,
            'testimonies' => $testimonies,
            'stats' => $stats
        ]);
    }

    /**
     * Afficher les détails d'un témoignage
     */
    public function show(WitnessTestimony $testimony)
    {
        $testimony->load(['user', 'validator']);

        return response()->json([
            'success' => true,
            'testimony' => $testimony
        ]);
    }

    /**
     * Mettre à jour le contenu d'un témoignage
     */
    public function update(Request $request, WitnessTestimony $testimony)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|min:8|max:120',
            'category' => 'sometimes|string',
            'description' => 'sometimes|string|min:30|max:1500',
            'location' => 'sometimes|string|max:200',
            'event_date' => 'sometimes|date',
            'anonymous_publication' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only([
                'title', 'category', 'description', 'location',
                'event_date', 'anonymous_publication'
            ]);

            // Gérer l'upload de nouveaux médias
            if ($request->hasFile('media_files')) {
                $mediaFiles = $testimony->media_files ?? [];
                foreach ($request->file('media_files') as $file) {
                    $path = $file->store('witness/testimonies', 'public');
                    $mediaFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType(),
                        'is_video' => str_starts_with($file->getMimeType(), 'video/'),
                    ];
                }
                $data['media_files'] = $mediaFiles;
            }

            $testimony->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Témoignage mis à jour avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Valider un témoignage
     */
    public function validateInvestigation(WitnessTestimony $testimony)
    {
        if ($testimony->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Seuls les témoignages en attente peuvent être validés'
            ], 400);
        }

        try {
            $testimony->validate(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Témoignage validé avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation'
            ], 500);
        }
    }

    /**
     * Rejeter un témoignage
     */
    public function rejectInvestigation(Request $request, WitnessTestimony $testimony)
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
            $testimony->reject($request->rejection_reason, Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Témoignage rejeté avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet'
            ], 500);
        }
    }

    /**
     * Publier un témoignage validé
     */
    public function publish(WitnessTestimony $testimony)
    {
        if ($testimony->status !== 'validated') {
            return response()->json([
                'success' => false,
                'message' => 'Seuls les témoignages validés peuvent être publiés'
            ], 400);
        }

        try {
            $testimony->publish();

            return response()->json([
                'success' => true,
                'message' => 'Témoignage publié avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la publication'
            ], 500);
        }
    }

    /**
     * Dépublier un témoignage
     */
    public function unpublish(WitnessTestimony $testimony)
    {
        if ($testimony->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'Ce témoignage n\'est pas publié'
            ], 400);
        }

        try {
            $testimony->update([
                'status' => 'validated',
                'published_at' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Témoignage dépublié avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la dépublication'
            ], 500);
        }
    }

    /**
     * Mettre à jour le statut d'un témoignage
     */
    public function updateStatus(Request $request, WitnessTestimony $testimony)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,validated,rejected,published',
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
                    $testimony->validate(Auth::id());
                    break;
                case 'rejected':
                    $testimony->reject($request->rejection_reason, Auth::id());
                    break;
                case 'published':
                    if ($testimony->status === 'validated') {
                        $testimony->publish();
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Seuls les témoignages validés peuvent être publiés'
                        ], 400);
                    }
                    break;
                case 'pending':
                    $testimony->update([
                        'status' => 'pending',
                        'rejection_reason' => null,
                        'validated_at' => null,
                        'validated_by' => null,
                        'published_at' => null,
                    ]);
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }
    }

    /**
     * Supprimer un fichier média
     */
    public function deleteMedia(Request $request, WitnessTestimony $testimony)
    {
        $validator = Validator::make($request->all(), [
            'media_path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $mediaFiles = $testimony->media_files ?? [];
            $mediaPath = $request->media_path;

            $mediaFiles = array_filter($mediaFiles, function($media) use ($mediaPath) {
                return $media['path'] !== $mediaPath;
            });

            // Supprimer le fichier du storage
            Storage::disk('public')->delete($mediaPath);

            $testimony->update(['media_files' => array_values($mediaFiles)]);

            return response()->json([
                'success' => true,
                'message' => 'Média supprimé avec succès',
                'testimony' => $testimony->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du média'
            ], 500);
        }
    }

    /**
     * Supprimer un témoignage (soft delete)
     */
    public function destroy(WitnessTestimony $testimony)
    {
        try {
            $testimony->delete();

            return response()->json([
                'success' => true,
                'message' => 'Témoignage supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }
    }

    /**
     * Restaurer un témoignage supprimé
     */
    public function restore($id)
    {
        try {
            $testimony = WitnessTestimony::withTrashed()->findOrFail($id);
            $testimony->restore();

            return response()->json([
                'success' => true,
                'message' => 'Témoignage restauré avec succès',
                'testimony' => $testimony->fresh()
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
            'action' => 'required|in:validate,reject,publish,unpublish,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:witness_testimonies,id',
            'rejection_reason' => 'required_if:action,reject|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $testimonies = WitnessTestimony::whereIn('id', $request->ids)->get();
            $action = $request->action;
            $count = 0;

            foreach ($testimonies as $testimony) {
                switch ($action) {
                    case 'validate':
                        if ($testimony->status === 'pending') {
                            $testimony->validate(Auth::id());
                            $count++;
                        }
                        break;
                    case 'reject':
                        if ($testimony->status === 'pending') {
                            $testimony->reject($request->rejection_reason, Auth::id());
                            $count++;
                        }
                        break;
                    case 'publish':
                        if ($testimony->status === 'validated') {
                            $testimony->publish();
                            $count++;
                        }
                        break;
                    case 'unpublish':
                        if ($testimony->status === 'published') {
                            $testimony->update([
                                'status' => 'validated',
                                'published_at' => null,
                            ]);
                            $count++;
                        }
                        break;
                    case 'delete':
                        $testimony->delete();
                        $count++;
                        break;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "{$count} témoignage(s) traité(s) avec succès",
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
