@extends('layouts.frontend')

@section('title', 'Vidéos - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black mb-4">📺 Vidéos</h1>
        <p class="text-xl text-gray-600">Retrouvez toutes nos émissions et reportages</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-3 overflow-x-auto pb-4 mb-8 border-b-2 border-gray-200">
        <button class="px-6 py-3 bg-blue-600 text-white rounded-full font-bold whitespace-nowrap">
            📺 Toutes les vidéos
        </button>
        <button class="px-6 py-3 bg-white border-2 border-gray-300 rounded-full font-bold whitespace-nowrap hover:border-blue-600 transition">
            🗞️ Journal
        </button>
        <button class="px-6 py-3 bg-white border-2 border-gray-300 rounded-full font-bold whitespace-nowrap hover:border-blue-600 transition">
            🎙️ Émissions
        </button>
        <button class="px-6 py-3 bg-white border-2 border-gray-300 rounded-full font-bold whitespace-nowrap hover:border-blue-600 transition">
            📰 Reportages
        </button>
        <button class="px-6 py-3 bg-white border-2 border-gray-300 rounded-full font-bold whitespace-nowrap hover:border-blue-600 transition">
            ⚽ Sport
        </button>
    </div>

    <!-- Featured Video -->
    @if($featuredVideo)
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-12">
        <div class="aspect-video bg-gradient-to-br from-blue-900 to-blue-600 relative flex items-center justify-center cursor-pointer group">
            @if($featuredVideo->featured_image)
                <img src="{{ asset('storage/' . $featuredVideo->featured_image) }}"
                     alt="{{ $featuredVideo->title }}"
                     class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                <div class="w-24 h-24 bg-white/95 rounded-full flex items-center justify-center text-blue-600 text-4xl group-hover:scale-110 transition shadow-2xl">
                    ▶
                </div>
            </div>
            <span class="absolute top-4 left-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold uppercase">
                Nouveau
            </span>
            @if($featuredVideo->video_duration)
            <span class="absolute bottom-4 right-4 bg-black/80 text-white px-3 py-1 rounded font-bold text-sm">
                {{ gmdate('H:i:s', $featuredVideo->video_duration) }}
            </span>
            @endif
        </div>
        <div class="p-8">
            <h2 class="text-3xl font-bold mb-4">{{ $featuredVideo->title }}</h2>
            <div class="flex gap-6 text-sm text-gray-600 mb-4">
                <span>📅 {{ $featuredVideo->formatted_published_date }}</span>
                <span>👁️ {{ number_format($featuredVideo->views_count) }} vues</span>
                <span>💬 {{ $featuredVideo->comments_count }} commentaires</span>
            </div>
            @if($featuredVideo->excerpt)
            <p class="text-gray-700 leading-relaxed">
                {{ $featuredVideo->excerpt }}
            </p>
            @endif
        </div>
    </div>
    @endif

    <!-- Recent Videos Grid -->
    <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-red-600">Vidéos récentes</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
        @foreach($recentVideos as $video)
        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition cursor-pointer">
            <a href="{{ route('publication.show', $video->slug) }}">
                <div class="aspect-video bg-gradient-to-br from-red-500 to-orange-500 relative flex items-center justify-center group">
                    @if($video->featured_image)
                        <img src="{{ asset('storage/' . $video->featured_image) }}"
                             alt="{{ $video->title }}"
                             class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <div class="w-16 h-16 bg-white/95 rounded-full flex items-center justify-center text-red-600 text-2xl">
                            ▶
                        </div>
                    </div>
                    @if($video->type === 'direct')
                    <span class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold uppercase animate-pulse">
                        Live
                    </span>
                    @endif
                    @if($video->video_duration)
                    <span class="absolute bottom-2 right-2 bg-black/80 text-white px-2 py-1 rounded text-xs font-bold">
                        {{ gmdate('i:s', $video->video_duration) }}
                    </span>
                    @endif
                </div>
                <div class="p-4">
                    <span class="text-xs text-blue-600 font-bold uppercase">
                        {{ $video->rubrique->name }}
                    </span>
                    <h3 class="font-bold text-base mt-2 mb-2 leading-tight line-clamp-2">
                        {{ $video->title }}
                    </h3>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ $video->published_at->diffForHumans() }}</span>
                        <span>{{ number_format($video->views_count) }} vues</span>
                    </div>
                </div>
            </a>
        </article>
        @endforeach
    </div>

    <!-- Shorts Section -->
    @if($shorts->isNotEmpty())
    <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-red-600">Shorts</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($shorts as $short)
        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:scale-105 transition cursor-pointer">
            <a href="{{ route('publication.show', $short->slug) }}">
                <div class="aspect-[9/16] bg-gradient-to-br from-purple-500 to-pink-500 relative flex items-center justify-center group">
                    @if($short->featured_image)
                        <img src="{{ asset('storage/' . $short->featured_image) }}"
                             alt="{{ $short->title }}"
                             class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <div class="w-12 h-12 bg-white/95 rounded-full flex items-center justify-center text-purple-600 text-xl">
                            ▶
                        </div>
                    </div>
                    @if($short->video_duration)
                    <span class="absolute bottom-2 right-2 bg-black/80 text-white px-2 py-1 rounded text-xs font-bold">
                        0:{{ str_pad($short->video_duration, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-sm leading-tight line-clamp-2">
                        {{ $short->title }}
                    </h3>
                    <span class="text-xs text-gray-500 block mt-1">
                        {{ number_format($short->views_count) }} vues
                    </span>
                </div>
            </a>
        </article>
        @endforeach
    </div>
    @endif
</div>
@endsection
