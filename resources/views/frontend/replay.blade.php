@extends('layouts.frontend')

@section('title', 'Replay - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Coming Soon Section -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl shadow-xl p-12 text-center">
            <!-- Icon -->
            <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-600 rounded-full mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Title -->
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Bientôt disponible</h2>

            <!-- Description -->
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Notre plateforme de replay est en cours de préparation. Vous pourrez bientôt retrouver toutes vos émissions favorites à la demande.
            </p>

            <!-- Features -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Accès 24/7</h3>
                    <p class="text-gray-600 text-sm">Regardez vos émissions quand vous voulez</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Toutes les émissions</h3>
                    <p class="text-gray-600 text-sm">Une bibliothèque complète et organisée</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Qualité HD</h3>
                    <p class="text-gray-600 text-sm">Profitez d'une excellente qualité d'image</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Retour à l'accueil
                </a>

                <a href="{{ route('direct') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-50 transition shadow-lg border-2 border-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Regarder le direct
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
