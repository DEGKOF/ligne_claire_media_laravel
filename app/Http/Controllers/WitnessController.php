<?php

namespace App\Http\Controllers;

use App\Models\WitnessTestimony;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WitnessController extends Controller
{
    /**
     * Afficher la page du pôle témoins
     */
    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
            // 'breakingNews',

        $testimonies = WitnessTestimony::with('user')
            // ->published()
            ->whereIn('status', [
                // 'pending',
                'validated'
                ])
            ->latest('published_at')
            ->paginate(12);
// dd($testimonies);
        return view('witness.index', compact('testimonies','breakingNews',));
    }

    /**
     * Soumettre un témoignage
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:120',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'title' => 'required|string|min:8|max:120',
            'category' => 'required|string',
            'description' => 'required|string|min:30|max:2000',
            'location' => 'nullable|string|max:200',
            'event_date' => 'nullable|date',
            'anonymous_publication' => 'boolean',
            'consent_given' => 'required|accepted',
            'media_files.*' => 'nullable|file|mimes:jpeg,jpg,png|max:102400', // 200MB max
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
                    'role' => 'witness',
                    'is_active' => true,
                ]);

                // Créer le profil témoin
                $user->createProfile();
            }
            // else {
            //     // Si l'utilisateur existe mais n'est pas témoin, mettre à jour son rôle
            //     if ($user->role !== 'witness' && !$user->isInternalUser()) {
            //         $user->update(['role' => 'witness']);
            //         $user->createProfile();
            //     }
            // }

            // Gérer l'upload des médias si présents
            $mediaFiles = [];
            if ($request->hasFile('media_files')) {
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
            }

            // Créer le témoignage
            $testimony = WitnessTestimony::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'category' => $request->category,
                'description' => $request->description,
                'location' => $request->location,
                'event_date' => $request->event_date,
                'media_files' => $mediaFiles,
                'anonymous_publication' => $request->boolean('anonymous_publication'),
                'consent_given' => true,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Témoignage envoyé avec succès ! Statut : En attente de validation.',
                'testimony' => [
                    'id' => $testimony->id,
                    'title' => $testimony->title,
                    'status' => $testimony->status_label,
                    'created_at' => $testimony->created_at->format('d/m/Y H:i'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les témoignages d'un utilisateur
     */
    public function myTestimonies(Request $request)
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
                'testimonies' => []
            ]);
        }

        $testimonies = WitnessTestimony::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($testimony) {
                return [
                    'id' => $testimony->id,
                    'title' => $testimony->title,
                    'category' => $testimony->category,
                    'location' => $testimony->location,
                    'status' => $testimony->status,
                    'status_label' => $testimony->status_label,
                    'created_at' => $testimony->created_at->format('d/m/Y H:i'),
                    'rejection_reason' => $testimony->rejection_reason,
                ];
            });

        return response()->json([
            'success' => true,
            'testimonies' => $testimonies
        ]);
    }
    // Ajouter cette méthode dans App\Http\Controllers\WitnessController.php

    /**
     * Afficher les détails d'un témoignage avec tous ses médias
     */
    public function show(WitnessTestimony $testimony)
    {
        // Vérifier que le témoignage est publié ou validé
        if (!in_array($testimony->status, ['pending', 'validated'])) {
            abort(404);
        }

        $testimony->load('user');

        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        // Témoignages similaires (même catégorie)
        $relatedTestimonies = WitnessTestimony::with('user')
            ->whereIn('status', ['pending', 'validated'])
            ->where('category', $testimony->category)
            ->where('id', '!=', $testimony->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('witness.show', compact('testimony', 'breakingNews', 'relatedTestimonies'));
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
