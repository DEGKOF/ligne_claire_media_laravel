<?php

namespace App\Http\Controllers;

use App\Models\CommunitySubmission;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    /**
     * Afficher la page du pôle communauté
     */
    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            // ->take(5)
            ->get();
            // 'breakingNews',

        $submissions = CommunitySubmission::with('user')
            // ->published()
            ->where('status', 'validated')
            ->latest('published_at')
            ->paginate(12);

            // dd($submissions);
        return view('community.index', compact('submissions','breakingNews'));
    }

    /**
     * Soumettre un article (avec création de compte si nécessaire)
     */
    public function submit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:120',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'title' => 'required|string|min:10|max:200',
            'section' => 'required|string|in:Société,Économie,Politique,Tech & IA,Culture,Environnement,Investigation',
            'access_type' => 'required|in:free,premium',
            'summary' => 'nullable|string|max:10000',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            // Vérifier si l'utilisateur existe
            $user = User::where('email', $request->email)->first();

            // Si l'utilisateur n'existe pas, créer un compte
            if (!$user) {
                $nameParts = explode(' ', $request->name, 2);
                $prenom = $nameParts[0] ?? '';
                $nom = $nameParts[1] ?? '';

                $user = User::create([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'username' => $this->generateUsername($request->email),
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'city' => $request->city,
                    'password' => '$2y$12$gjXgHDz8ac5APX59Fik.TuxpfVTGGLO1f89MOnNiHr1Z1fv55axWe', // defaulst password => password
                    'role' => 'contributor',
                    'is_active' => true,
                ]);

                // Créer le profil contributeur
                $user->createProfile();
            }
            // else {
            //     // Si l'utilisateur existe mais n'est pas contributeur, mettre à jour son rôle
            //     if ($user->role !== 'contributor' && !$user->isInternalUser()) {
            //         $user->update(['role' => 'contributor']);
            //         $user->createProfile();
            //     }
            // }

            // Gérer l'upload de l'image si présente
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('community/submissions', 'public');
            }

            // Créer la soumission
            $submission = CommunitySubmission::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'section' => $request->section,
                'access_type' => $request->access_type,
                'summary' => $request->summary,
                'image_path' => $imagePath,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Soumission envoyée avec succès ! Statut : En attente de validation.',
                'submission' => [
                    'id' => $submission->id,
                    'title' => $submission->title,
                    'status' => $submission->status_label,
                    'created_at' => $submission->created_at->format('d/m/Y H:i'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.'
            ], 500);
        }
    }

    /**
     * Récupérer les soumissions d'un utilisateur
     */
    public function mySubmissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => true,
                'submissions' => []
            ]);
        }

        $submissions = CommunitySubmission::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'title' => $submission->title,
                    'section' => $submission->section,
                    'access_type' => $submission->access_type,
                    'status' => $submission->status,
                    'status_label' => $submission->status_label,
                    'created_at' => $submission->created_at->format('d/m/Y H:i'),
                    'rejection_reason' => $submission->rejection_reason,
                ];
            });

        return response()->json([
            'success' => true,
            'submissions' => $submissions
        ]);
    }
    /**
     * Afficher le détail d'une soumission
     */
    public function show(CommunitySubmission $submission)
    {
        // Charger les relations nécessaires
        $submission->load('user');

        // Récupérer d'autres soumissions du même auteur
        $otherSubmissions = CommunitySubmission::where('user_id', $submission->user_id)
            ->where('id', '!=', $submission->id)
            ->latest()
            ->take(3)
            ->get();

        // Récupérer des soumissions similaires (même section)
        $relatedSubmissions = CommunitySubmission::where('section', $submission->section)
            ->where('id', '!=', $submission->id)
            ->latest()
            ->take(4)
            ->get();

        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('community.show', compact(
            'submission',
            'otherSubmissions',
            'relatedSubmissions',
            'breakingNews'
        ));
    }
    /**
     * Générer un username unique à partir de l'email
     */
    private function generateUsername($email)
    {
        $base = explode('@', $email)[0];
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }
}
