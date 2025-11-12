{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.frontend')

@section('title', 'Inscription - LIGNE CLAIRE MÉDIA+')

@push('styles')
<style>
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
        border-bottom-color: #10b981;
        background: transparent;
    }

    .underline-input::placeholder {
        color: #9ca3af;
    }

    .register-container {
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

    .btn-register {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
    }

    .auth-link {
        color: #3b82f6;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .auth-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }

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

    @media (max-width: 640px) {
        .register-container {
            padding: 2rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Créer un compte
            </h2>
            <p class="text-gray-600">
                Rejoignez la communauté LIGNE CLAIRE MÉDIA+
            </p>
        </div>

        <div class="register-container bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10">

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Nom et Prénom -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom
                            </label>
                            <input
                                id="nom"
                                type="text"
                                name="nom"
                                value="{{ old('nom') }}"
                                required
                                autofocus
                                autocomplete="family-name"
                                class="underline-input w-full text-gray-900"
                            >
                            @error('nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2">
                                Prénom
                            </label>
                            <input
                                id="prenom"
                                type="text"
                                name="prenom"
                                value="{{ old('prenom') }}"
                                required
                                autocomplete="given-name"
                                class="underline-input w-full text-gray-900"
                            >
                            @error('prenom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom d'utilisateur
                        </label>
                        <input
                            id="username"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                            class="underline-input w-full text-gray-900"
                        >
                        @error('username')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="underline-input w-full text-gray-900"
                        >
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
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
                            autocomplete="new-password"
                            class="underline-input w-full text-gray-900"
                        >
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmer mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="underline-input w-full text-gray-900"
                        >
                        @error('password_confirmation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton inscription -->
                    <button
                        type="submit"
                        class="btn-register w-full text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-green-300"
                    >
                        S'inscrire
                    </button>
                </form>
            </div>

            <!-- Connexion -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="auth-link font-semibold">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>

        <!-- Retour à l'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-green-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
