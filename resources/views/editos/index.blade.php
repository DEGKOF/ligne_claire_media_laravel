@extends('layouts.frontend')

@section('title', 'Éditos')

@section('content')

<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Éditos</h1>
            <p class="text-xl text-gray-600">Les points de vue de notre rédaction</p>
        </div>

        @if($latestEdito)
        <!-- Dernier édito - Mise en avant -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12 hover:shadow-2xl transition-shadow duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Image -->
                <div class="relative h-64 lg:h-auto">
                    @if($latestEdito->cover_image)
                        <img src="{{ asset('storage/'.$latestEdito->cover_image) }}"
                             alt="{{ $latestEdito->title }}"
                             class="w-full h-full object-cover">
                    @else
                        {{-- <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <i class="fas fa-pen-fancy text-white text-6xl opacity-50"></i>
                        </div> --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <i class="fas fa-pen-fancy text-white text-6xl opacity-50"></i>
                        </div>
                    @endif

                    <!-- Badge "Dernier édito" -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-600 text-white shadow-lg">
                            <i class="fas fa-star mr-2"></i>
                            Dernier édito
                        </span>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <!-- Date et auteur -->
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-blue-600"></i>
                            <span>{{ $latestEdito->published_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-blue-600"></i>
                            <span>Par <strong>{{ $latestEdito->user->nom ." ". $latestEdito->user->prenom }}</strong></span>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-4 hover:text-blue-600 transition">
                        <a href="{{ route('editos.show', $latestEdito->slug) }}">
                            {{ $latestEdito->title }}
                        </a>
                    </h2>

                    <!-- Extrait -->
                    <p class="text-gray-700 text-lg mb-6 line-clamp-4">
                        {!! strip_tags(preg_replace('/\s+/', ' ', $latestEdito->excerpt_or_content)) !!}
                    </p>

                    <!-- Bouton -->
                    <div>
                        <a href="{{ route('editos.show', $latestEdito->slug) }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                            Lire l'édito complet
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if($olderEditos->count() > 0)
        <!-- Anciens éditos -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Éditos précédents</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($olderEditos as $edito)
            <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Image -->
                <div class="relative h-48">
                    @if($edito->cover_image)
                        <img src="{{ asset('storage/'. $edito->cover_image) }}"
                             alt="{{ $edito->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                            <i class="fas fa-pen-fancy text-white text-4xl opacity-50"></i>
                        </div>
                    @endif
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <!-- Date et auteur -->
                    <div class="flex items-center gap-3 text-xs text-gray-600 mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-calendar"></i>
                            {{ $edito->published_at->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-user"></i>
                            {{ $edito->user->prenom ?? $edito->user->username }}
                        </span>
                    </div>

                    <!-- Titre -->
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition line-clamp-2">
                        <a href="{{ route('editos.show', $edito->slug) }}">
                            {{ $edito->title }}
                        </a>
                    </h3>

                    <!-- Extrait -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {!! strip_tags(preg_replace('/\s+/', ' ', $edito->excerpt_or_content)) !!}
                    </p>

                    <!-- Lire la suite -->
                    <a href="{{ route('editos.show', $edito->slug) }}"
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition">
                        Lire la suite
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @endif

        @else
        <!-- Aucun édito -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <i class="fas fa-pen-fancy text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Aucun édito disponible</h2>
            <p class="text-gray-500">Les éditos de notre rédaction apparaîtront ici prochainement.</p>
        </div>
        @endif
    </div>
</div>
@endsection
