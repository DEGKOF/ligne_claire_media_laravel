{{-- resources/views/auth/forgot-password.blade.php --}}

@extends('layouts.frontend')

@section('title', 'Mot de passe oublié - LIGNE CLAIRE MÉDIA+')

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
        border-bottom-color: #f59e0b;
        background: transparent;
    }

    .underline-input::placeholder {
        color: #9ca3af;
    }

    .forgot-container {
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

    .btn-forgot {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        transition: all 0.3s ease;
    }

    .btn-forgot:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
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
        .forgot-container {
            padding: 2rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">

        <div class="text-center mb-8">
            <div class="text-6xl mb-4">🔑</div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Mot de passe oublié ?
            </h2>
            <p class="text-gray-600">
                Pas de problème, nous vous enverrons un lien de réinitialisation
            </p>
        </div>

        <div class="forgot-container bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10">

                <div class="mb-6 text-sm text-gray-600 text-center">
                    Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                        <p class="font-medium text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

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
                            autofocus
                            placeholder="votre@email.com"
                            class="underline-input w-full text-gray-900"
                        >
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton envoyer -->
                    <button
                        type="submit"
                        class="btn-forgot w-full text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-orange-300"
                    >
                        Envoyer le lien de réinitialisation
                    </button>
                </form>
            </div>

            <!-- Connexion -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Vous vous souvenez de votre mot de passe ?
                    <a href="{{ route('login') }}" class="auth-link font-semibold">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>

        <!-- Retour à l'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-orange-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
