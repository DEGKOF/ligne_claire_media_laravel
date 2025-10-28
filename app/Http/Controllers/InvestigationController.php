<?php

namespace App\Http\Controllers;

use App\Models\InvestigationProposal;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InvestigationController extends Controller
{
    /**
     * Afficher la page du pôle investigation
     */
    // public function index()
    // {
    //     // Récupérer toutes les propositions (tous statuts) pour l'affichage dans la section "Enquêtes en cours"
    //     $proposals = InvestigationProposal::with('user')
    //         ->whereIn('status', ['pending', 'validated', 'in_progress', 'completed'])
    //         ->latest()
    //         ->get();

    //     // Calculer les KPIs
    //     $totalProposals = InvestigationProposal::count();
    //     $totalSupporters = 0; // À implémenter selon votre logique de soutien
    //     $totalFunds = InvestigationProposal::sum('budget_collected');
    //     $totalImpact = InvestigationProposal::where('status', 'completed')->count(); // Nombre d'enquêtes terminées comme indicateur d'impact

    //     return view('investigation.index', compact(
    //         'proposals',
    //         'totalProposals',
    //         'totalSupporters',
    //         'totalFunds',
    //         'totalImpact'
    //     ));
    // }

    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // 'breakingNews'

        // Récupérer toutes les propositions
        $proposals = InvestigationProposal::with('user')
            ->whereIn('status', ['pending', 'validated', 'in_progress', 'completed'])
            ->latest()
            ->get();

        // Calculer les KPIs
        $totalProposals = InvestigationProposal::count();
        $totalSupporters = 0;
        $totalFunds = InvestigationProposal::sum('budget_collected');
        $totalImpact = InvestigationProposal::where('status', 'completed')->count();

        // ✅ Récupérer l'email du user connecté (si connecté)
        $userEmail = auth()->check() ? auth()->user()->email : null;

        return view('investigation.index', compact(
            'proposals',
            'totalProposals',
            'totalSupporters',
            'breakingNews',
            'totalFunds',
            'totalImpact',
            'userEmail' // ✅ Passer l'email à la vue
        ));
    }

    /**
     * Soumettre une proposition d'enquête
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:120',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'title' => 'required|string|min:10|max:140',
            'theme' => 'required|string',
            'angle' => 'required|string|min:30|max:1200',
            'sources' => 'nullable|string|max:1600',
            'format' => 'required|string|in:Article long,Vidéo,Podcast,Infographie,Série multimédia',
            'budget' => 'nullable|numeric|min:0|max:999999999',
            'estimated_weeks' => 'nullable|integer|min:1|max:52',
            'needs' => 'nullable|string|max:1000',
            'files.*' => 'nullable|file|max:10240', // 10MB max par fichier
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
                    'password' => '$2y$12$gjXgHDz8ac5APX59Fik.TuxpfVTGGLO1f89MOnNiHr1Z1fv55axWe', // default password => password
                    'role' => 'investigator',
                    'is_active' => true,
                ]);

                // Créer le profil investigateur
                $user->createProfile();
            }

            // Gérer l'upload des fichiers si présents
            $files = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('investigation/proposals', 'public');
                    $files[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType(),
                    ];
                }
            }

            // Créer la proposition
            $proposal = InvestigationProposal::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'theme' => $request->theme,
                'angle' => $request->angle,
                'sources' => $request->sources,
                'format' => $request->format,
                'budget' => $request->budget,
                'estimated_weeks' => $request->estimated_weeks,
                'needs' => $request->needs,
                'files' => $files,
                'status' => 'pending',
            ]);

        // dd($proposal);
            return response()->json([
                'success' => true,
                'message' => 'Proposition envoyée avec succès ! Statut : En attente de validation.',
                'proposal' => [
                    'id' => $proposal->id,
                    'title' => $proposal->title,
                    'status' => $proposal->status_label ?? 'En attente',
                    'created_at' => $proposal->created_at->format('d/m/Y H:i'),
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la soumission de proposition: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.'
            ], 500);
        }
    }

    /**
     * Récupérer les propositions d'un utilisateur
     */
    public function myProposals(Request $request)
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
                'proposals' => []
            ]);
        }

        $proposals = InvestigationProposal::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($proposal) {
                return [
                    'id' => $proposal->id,
                    'title' => $proposal->title,
                    'theme' => $proposal->theme,
                    'format' => $proposal->format,
                    'budget' => $proposal->budget,
                    'budget_collected' => $proposal->budget_collected,
                    'status' => $proposal->status,
                    'status_label' => $proposal->status_label ?? 'En attente',
                    'created_at' => $proposal->created_at->format('d/m/Y H:i'),
                    'rejection_reason' => $proposal->rejection_reason,
                ];
            });

        return response()->json([
            'success' => true,
            'proposals' => $proposals
        ]);
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
