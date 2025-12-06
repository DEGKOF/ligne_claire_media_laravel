<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier uniquement si l'utilisateur est authentifié
        if (Auth::check()) {
            $user = Auth::user();

            // Vérifier si le compte est inactif
            if (!$user->is_active) {
                // Déconnecter l'utilisateur
                Auth::logout();

                // Invalider la session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Rediriger vers la page de connexion avec un message
                return redirect()->route('login')
                    ->with('error', 'Votre compte a été désactivé. Veuillez contacter l\'administrateur pour plus de détails.')
                    ->with('contact_email', 'admin@example.com'); // Configurable
            }
        }

        // Si l'utilisateur n'est pas connecté, laisser passer (pas de vérification)
        return $next($request);
    }
}
