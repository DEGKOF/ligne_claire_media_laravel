@extends('layouts.frontend')

@section('title', $publication->meta_title ?? $publication->title)
@section('meta_description', $publication->meta_description ?? $publication->excerpt)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Accueil</a></li>
                <li>→</li>
                <li><a href="{{ route('rubrique.show', $publication->rubrique->slug) }}" class="hover:text-blue-600">
                    {{ $publication->rubrique->name }}
                </a></li>
                <li>→</li>
                <li class="text-gray-900 font-semibold">Article</li>
            </ol>
        </nav>

        <!-- Article Header -->
        <article class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Rubrique Badge -->
            <div class="px-8 pt-8">
                <a href="{{ route('rubrique.show', $publication->rubrique->slug) }}"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-full text-xs font-bold uppercase hover:bg-blue-700 transition">
                    {{ $publication->rubrique->name }}
                </a>
                @if($publication->is_new)
                <span class="ml-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase animate-pulse">
                    NEW
                </span>
                @endif
            </div>

            <!-- Title -->
            <div class="px-8 pt-6">
                <h1 class="text-4xl md:text-5xl font-black leading-tight mb-6">
                    {{ $publication->title }}
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-6 text-sm text-gray-600 mb-6 pb-6 border-b">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">👤</span>
                        <span>Par <strong class="text-gray-900">{{ $publication->user->public_name }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📅</span>
                        <span>{{ $publication->formatted_published_date }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">👁️</span>
                        <span>{{ number_format($publication->views_count) }} vues</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">⏱️</span>
                        <span>{{ $publication->read_time }} min de lecture</span>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($publication->featured_image)
            <div class="px-8 mb-8">
                <img src="{{ asset('storage/' . $publication->featured_image) }}"
                     alt="{{ $publication->title }}"
                     class="w-full h-auto rounded-lg shadow-lg">
            </div>
            @endif

            <!-- Excerpt -->
            @if($publication->excerpt)
            <div class="px-8 mb-6">
                <p class="text-xl text-gray-700 leading-relaxed font-medium border-l-4 border-blue-600 pl-6 py-4 bg-blue-50 rounded">
                    {{ $publication->excerpt }}
                </p>
            </div>
            @endif

            <!-- Content -->
            <div class="px-8 pb-8">
                <div class="prose prose-lg max-w-none">
                    {{-- {!! nl2br(e($publication->content)) !!} --}}
                    {!! $publication->content !!}
                </div>

                <!-- Video URL si présent -->
                @if($publication->video_url)
                <div class="mt-8">
                    <div class="aspect-video bg-black rounded-lg overflow-hidden">
                        @if(str_contains($publication->video_url, 'youtube.com') || str_contains($publication->video_url, 'youtu.be'))
                            @php
                                $videoId = null;
                                if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $publication->video_url, $matches)) {
                                    $videoId = $matches[1];
                                } elseif (preg_match('/youtu\.be\/([^?]+)/', $publication->video_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe class="w-full h-full"
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            @endif
                        @else
                            <a href="{{ $publication->video_url }}" target="_blank" class="flex items-center justify-center h-full text-white hover:text-blue-400">
                                <span class="text-6xl">▶️</span>
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- External Link -->
                @if($publication->external_link)
                <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">🔗 Lien externe :</p>
                    <a href="{{ $publication->external_link }}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 font-semibold break-all">
                        {{ $publication->external_link }}
                    </a>
                </div>
                @endif

                <!-- Tags -->
                @if($publication->meta_keywords)
                <div class="mt-8 pt-6 border-t">
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $publication->meta_keywords) as $keyword)
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                                #{{ trim($keyword) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Buttons -->
                <div class="mt-8 pt-6 border-t">
                    <h3 class="font-bold mb-4">Partager cet article :</h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('publication.show', $publication->slug)) }}"
                           target="_blank"
                           class="bg-blue-600 text-white px-6 py-0 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('publication.show', $publication->slug)) }}&text={{ urlencode($publication->title) }}"
                           target="_blank"
                           class="bg-sky-500 text-white px-6 py-0 rounded-lg font-semibold hover:bg-sky-600 transition">
                            Twitter
                        </a>
                        <button onclick="navigator.share({title: '{{ $publication->title }}', url: '{{ route('publication.show', $publication->slug) }}'})"
                                class="bg-gray-700 text-white px-6 py-0 rounded-lg font-semibold hover:bg-gray-800 transition">
                            Plus
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Articles -->
        @if($relatedArticles->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Articles similaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedArticles as $related)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('publication.show', $related->slug) }}">
                        <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}"
                                     alt="{{ $related->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-white text-4xl">📰</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-sm leading-tight mb-2 line-clamp-2">
                                {{ $related->title }}
                            </h3>
                            <span class="text-xs text-gray-500">
                                {{ $related->published_at->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection
