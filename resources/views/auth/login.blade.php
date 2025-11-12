{{-- resources/views/auth/login.blade.php --}}

@extends('layouts.frontend')

@section('title', 'Connexion - LIGNE CLAIRE MÉDIA+')

@push('styles')
<style>
    /* Style pour les champs avec bordure inférieure uniquement */
    .underline-input {
        border: none;
        border-bottom: 2px solid #e5e7eb;
        border-radius: 0;
        padding: 0.75rem 0;
        background: transparent;
        transition: all 0.3s ease;
    }

    .underline-input:focus {
        outline: none;
        border-bottom-color: #3b82f6;
        background: transparent;
    }

    .underline-input::placeholder {
        color: #9ca3af;
    }

    /* Animation pour le container de login */
    .login-container {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Style pour le bouton */
    .btn-login {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
    }

    /* Style pour les liens */
    .auth-link {
        color: #3b82f6;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .auth-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    /* Style pour les messages d'erreur */
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        animation: shake 0.5s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    /* Style pour le checkbox */
    .custom-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #d1d5db;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-checkbox:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .login-container {
            padding: 2rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Logo et Titre -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Bon retour !
            </h2>
            <p class="text-gray-600">
                Connectez-vous pour accéder à votre espace
            </p>
        </div>

        <!-- Container de connexion -->
        <div class="login-container bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10">
                <!-- Message de statut de session -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                        <p class="font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Formulaire de connexion -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="votre@email.com"
                            class="underline-input w-full text-gray-900 placeholder-gray-400 focus:border-blue-600"
                        >
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="underline-input w-full text-gray-900 placeholder-gray-400 focus:border-blue-600"
                        >

                    </div>

                    <!-- Se souvenir de moi & Mot de passe oublié -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="custom-checkbox"
                            >
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition">
                                Se souvenir de moi
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm auth-link">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Bouton de connexion -->
                    <button
                        type="submit"
                        class="btn-login w-full text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Se connecter
                    </button>
                </form>
            </div>

            <!-- Inscription -->
            {{-- <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Vous n'avez pas de compte ?
                    <a href="{{ route('register') }}" class="auth-link font-semibold">
                        Créer un compte
                    </a>
                </p>
            </div> --}}
        </div>

        <!-- Retour à l'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
