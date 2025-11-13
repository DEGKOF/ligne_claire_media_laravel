<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunitySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminCommunityController extends Controller
{
    /**
     * Afficher la liste des soumissions communautaires
     */
    public function index(Request $request)
    {
        $query = CommunitySubmission::with(['user', 'validator']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('access_type')) {
            $query->where('access_type', $request->access_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
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

        $submissions = $query->paginate($request->get('per_page', 20));

        // Statistiques
        $stats = [
            'total' => CommunitySubmission::count(),
            'pending' => CommunitySubmission::pending()->count(),
            'validated' => CommunitySubmission::validated()->count(),
            'rejected' => CommunitySubmission::rejected()->count(),
            'published' => CommunitySubmission::published()->count(),
        ];

        return view('admin.community.index', compact('submissions', 'stats'));
    }

    /**
     * Afficher les détails d'une soumission (API JSON)
     */
    public function show(CommunitySubmission $submission)
    {
        $submission->load(['user', 'validator']);

        return response()->json([
            'success' => true,
            'submission' => $submission
        ]);
    }

    /**
     * Mettre à jour le contenu d'une soumission
     */
    public function update(Request $request, CommunitySubmission $submission)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|min:10|max:200',
            'section' => 'sometimes|string|in:Société,Économie,Politique,Tech & IA,Culture,Environnement,Investigation',
            'access_type' => 'sometimes|in:free,premium',
            'summary' => 'sometimes|string|max:5000',
            'content' => 'sometimes|string|max:10000',
            'image' => 'sometimes|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only(['title', 'section', 'access_type', 'summary', 'content']);

            // Gérer l'upload de la nouvelle image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($submission->image_path) {
                    Storage::disk('public')->delete($submission->image_path);
                }
                $data['image_path'] = $request->file('image')->store('community/submissions', 'public');
            }

            $submission->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Soumission mise à jour avec succès',
                'submission' => $submission->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Valider une soumission
     */
    public function validateCommunity(Request $request, CommunitySubmission $submission)
    {
        try {
            $publishImmediately = $request->boolean('publish_immediately', false);
            $submission->validate(Auth::id(), $publishImmediately);

            return response()->json([
                'success' => true,
                'message' => $publishImmediately
                    ? 'Soumission validée et publiée avec succès'
                    : 'Soumission validée avec succès',
                'submission' => $submission->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rejeter une soumission
     */
    public function rejectvalidateCommunity(Request $request, CommunitySubmission $submission)
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
            $submission->reject($request->rejection_reason, Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Soumission rejetée avec succès',
                'submission' => $submission->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Publier une soumission validée
     */
    public function publish(CommunitySubmission $submission)
    {
        if ($submission->status !== 'validated') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les soumissions validées peuvent être publiées'
            ], 400);
        }

        try {
            $submission->publish();

            return response()->json([
                'success' => true,
                'message' => 'Soumission publiée avec succès',
                'submission' => $submission->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la publication: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dépublier une soumission
     */
    public function unpublish(CommunitySubmission $submission)
    {
        if (!$submission->published_at) {
            return response()->json([
                'success' => false,
                'message' => 'Cette soumission n\'est pas publiée'
            ], 400);
        }

        try {
            $submission->update(['published_at' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Soumission dépubliée avec succès',
                'submission' => $submission->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la dépublication: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une soumission (soft delete)
     */
    public function destroy(CommunitySubmission $submission)
    {
        try {
            $submission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Soumission supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actions en masse
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:validate,reject,delete,publish,unpublish',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:community_submissions,id',
            'rejection_reason' => 'required_if:action,reject|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $submissions = CommunitySubmission::whereIn('id', $request->ids)->get();
            $action = $request->action;
            $count = 0;

            foreach ($submissions as $submission) {
                switch ($action) {
                    case 'validate':
                        if ($submission->status === 'pending') {
                            $submission->validate(Auth::id());
                            $count++;
                        }
                        break;
                    case 'reject':
                        if ($submission->status === 'pending') {
                            $submission->reject($request->rejection_reason, Auth::id());
                            $count++;
                        }
                        break;
                    case 'delete':
                        $submission->delete();
                        $count++;
                        break;
                    case 'publish':
                        if ($submission->status === 'validated' && !$submission->published_at) {
                            $submission->publish();
                            $count++;
                        }
                        break;
                    case 'unpublish':
                        if ($submission->published_at) {
                            $submission->update(['published_at' => null]);
                            $count++;
                        }
                        break;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "{$count} soumission(s) traitée(s) avec succès",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement en masse: ' . $e->getMessage()
            ], 500);
        }
    }
}
