@extends('layouts.frontend')

@section('title', 'Replay - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black mb-4">📺 Replays</h1>
        <p class="text-xl text-gray-600">Retrouvez toutes nos émissions en replay</p>
    </div>

    @php
        $replays = \App\Models\Publication::published()
            ->byType('rediffusion')
            ->with(['user', 'rubrique'])
            ->latest('published_at')
            ->take(12)
            ->get();
    @endphp

    @if($replays->isEmpty())
        <div class="text-center py-16">
            <p class="text-2xl text-gray-600">Aucun replay disponible pour le moment.</p>
        </div>
    @else
        <!-- Featured Replay -->
        @php $featured = $replays->first(); @endphp
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-12">
            <div class="aspect-video bg-gradient-to-br from-blue-900 to-blue-600 relative flex items-center justify-center cursor-pointer group">
                @if($featured->featured_image)
                    <img src="{{ asset('storage/' . $featured->featured_image) }}"
                         alt="{{ $featured->title }}"
                         class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                    <div class="w-24 h-24 bg-white/95 rounded-full flex items-center justify-center text-blue-600 text-4xl group-hover:scale-110 transition shadow-2xl">
                        ▶
                    </div>
                </div>
                <span class="absolute top-4 left-4 bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold uppercase">
                    Nouveau
                </span>
                @if($featured->video_duration)
                <span class="absolute bottom-4 right-4 bg-black/80 text-white px-3 py-2 rounded font-bold">
                    {{ gmdate('H:i:s', $featured->video_duration) }}
                </span>
                @endif
            </div>
            <div class="p-8">
                <h2 class="text-3xl font-bold mb-4">
                    <a href="{{ route('publication.show', $featured->slug) }}" class="hover:text-blue-600 transition">
                        {{ $featured->title }}
                    </a>
                </h2>
                <div class="flex flex-wrap gap-6 text-sm text-gray-600 mb-4">
                    <span>📅 {{ $featured->formatted_published_date }}</span>
                    <span>👁️ {{ number_format($featured->views_count) }} vues</span>
                    <span>💬 {{ $featured->comments_count }} commentaires</span>
                </div>
                @if($featured->excerpt)
                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $featured->excerpt }}
                </p>
                @endif
                <a href="{{ route('publication.show', $featured->slug) }}"
                   class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition">
                    Regarder →
                </a>
            </div>
        </div>

        <!-- Replays Grid -->
        <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-blue-600">Tous les replays</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($replays->skip(1) as $replay)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition cursor-pointer">
                <a href="{{ route('publication.show', $replay->slug) }}">
                    <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-500 relative flex items-center justify-center group">
                        @if($replay->featured_image)
                            <img src="{{ asset('storage/' . $replay->featured_image) }}"
                                 alt="{{ $replay->title }}"
                                 class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <div class="w-16 h-16 bg-white/95 rounded-full flex items-center justify-center text-blue-600 text-2xl">
                                ▶
                            </div>
                        </div>
                        @if($replay->video_duration)
                        <span class="absolute bottom-2 right-2 bg-black/80 text-white px-2 py-1 rounded text-xs font-bold">
                            {{ gmdate('i:s', $replay->video_duration) }}
                        </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-blue-600 font-bold uppercase">
                            {{ $replay->rubrique->name }}
                        </span>
                        <h3 class="font-bold text-base mt-2 mb-2 leading-tight line-clamp-2">
                            {{ $replay->title }}
                        </h3>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $replay->published_at->format('d/m/Y') }}</span>
                            <span>{{ number_format($replay->views_count) }} vues</span>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        <!-- Load More Button -->
        @if($replays->count() >= 12)
        <div class="text-center mt-12">
            <button class="bg-blue-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-700 transition shadow-lg">
                Charger plus de vidéos
            </button>
        </div>
        @endif
    @endif

    <!-- Émissions populaires -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-blue-600">Émissions populaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @php
                $emissions = [
                    ['name' => 'Le Journal', 'icon' => '📰'],
                    ['name' => 'Face à l\'Info', 'icon' => '🎙️'],
                    ['name' => 'Le Grand Matin', 'icon' => '☕'],
                    ['name' => 'L\'Heure des Pros', 'icon' => '💼'],
                    ['name' => 'Les Grandes Gueules', 'icon' => '🗣️'],
                    ['name' => 'Le Débat', 'icon' => '⚖️'],
                ];
            @endphp
            @foreach($emissions as $emission)
            <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl hover:-translate-y-1 transition cursor-pointer">
                <div class="text-4xl mb-3">{{ $emission['icon'] }}</div>
                <h3 class="font-bold text-sm">{{ $emission['name'] }}</h3>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
