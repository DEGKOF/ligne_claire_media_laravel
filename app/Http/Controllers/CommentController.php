<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Récupérer les commentaires d'une publication
     */
    // public function index(Publication $publication)
    // {
    //     $comments = $publication->approvedComments()
    //         ->with('user')
    //         ->paginate(10);

    //     return response()->json([
    //         'success' => true,
    //         'comments' => $comments->items(),
    //         'pagination' => [
    //             'current_page' => $comments->currentPage(),
    //             'last_page' => $comments->lastPage(),
    //             'total' => $comments->total(),
    //         ]
    //     ]);
    // }
public function index(Publication $publication)
{
    $comments = $publication->approvedComments()
        ->with('user')
        ->paginate(10);

    // Transformer les commentaires pour le debug
    $commentsData = $comments->map(function($comment) {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user_id' => $comment->user_id,
            'guest_name' => $comment->guest_name,
            'guest_email' => $comment->guest_email,
            'author_name' => $comment->author_name,
            'author_initials' => $comment->author_initials,
            'time_ago' => $comment->time_ago,
            'created_at' => $comment->created_at->toIso8601String(),
        ];
    });

    // \Log::info('Comments loaded:', ['comments' => $commentsData->toArray()]);

    return response()->json([
        'success' => true,
        'comments' => $commentsData,
        'pagination' => [
            'current_page' => $comments->currentPage(),
            'last_page' => $comments->lastPage(),
            'total' => $comments->total(),
        ]
    ]);
}
    /**
     * Stocker un nouveau commentaire
     */
    public function store(Request $request, Publication $publication)
    {
        // Validation
        $rules = [
            'content' => 'required|string|min:3|max:1000',
        ];

        // Si l'utilisateur n'est pas connecté, demander nom et email
        if (!auth()->check()) {
            $rules['guest_name'] = 'required|string|max:100';
            $rules['guest_email'] = 'required|email|max:100';
        }

        $validator = Validator::make($request->all(), $rules, [
            'content.required' => 'Le commentaire est obligatoire.',
            'content.min' => 'Le commentaire doit contenir au moins 3 caractères.',
            'content.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
            'guest_name.required' => 'Votre nom est obligatoire.',
            'guest_email.required' => 'Votre email est obligatoire.',
            'guest_email.email' => 'L\'email n\'est pas valide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Créer le commentaire
        $comment = new Comment();
        $comment->publication_id = $publication->id;
        $comment->content = $request->content;
        $comment->ip_address = $request->ip();
        $comment->user_agent = $request->userAgent();

        if (auth()->check()) {
            $comment->user_id = auth()->id();
            // Charger la relation user
            $comment->save();
            $comment->load('user');
        } else {
            $comment->guest_name = $request->guest_name;
            $comment->guest_email = $request->guest_email;
            $comment->save();
        }

        // Incrémenter le compteur de commentaires
        $publication->increment('comments_count');

        // Construire la réponse avec les bonnes données
        $authorName = $comment->user_id && $comment->user
            ? $comment->user->public_name
            : $comment->guest_name;

        $words = explode(' ', $authorName);
        $initials = count($words) >= 2
            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
            : strtoupper(substr($authorName, 0, 2));

        return response()->json([
            'success' => true,
            'message' => 'Commentaire ajouté avec succès !',
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'author_name' => $authorName,
                'author_initials' => $initials,
                'time_ago' => $comment->created_at->locale('fr')->diffForHumans(),
                'created_at' => $comment->created_at->toIso8601String(),
            ]
        ], 201);
    }

    /**
     * Récupérer les infos de l'utilisateur connecté
     */
    public function getUserInfo(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'name' => $user->public_name,
                    'email' => $user->email,
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }
}
