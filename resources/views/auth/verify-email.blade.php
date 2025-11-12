{{-- resources/views/auth/verify-email.blade.php --}}

@extends('layouts.frontend')

@section('title', 'Vérifier votre email - LIGNE CLAIRE MÉDIA+')

@push('styles')
<style>
    .verify-container {
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

    .btn-verify {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        transition: all 0.3s ease;
    }

    .btn-verify:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
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

    @media (max-width: 640px) {
        .verify-container {
            padding: 2rem 1rem;
        }
    }
</style>
@endpush

@section('content')
@php

        $breakingNews = App\Models\Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
@endphp
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">

        <div class="text-center mb-8">
            <div class="text-6xl mb-4">📧</div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Vérifiez votre email
            </h2>
            <p class="text-gray-600">
                Un lien de vérification a été envoyé
            </p>
        </div>

        <div class="verify-container bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10">

                <div class="mb-6 text-sm text-gray-600 text-center">
                    Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons volontiers un autre.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                        <p class="font-medium text-sm">
                            Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="btn-verify w-full text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-300"
                    >
                        Renvoyer l'email de vérification
                    </button>
                </form>
            </div>

            <!-- Déconnexion -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm text-gray-600 hover:text-gray-900 font-medium">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>

        <!-- Retour à l'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-purple-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
