@extends('layouts.frontend')

@section('title', $publication->meta_title ?? $publication->title)
@section('meta_description', $publication->meta_description ?? $publication->excerpt)

@section('content')

<style>
    /* Par défaut, cacher l'élément */
    .shareOnPhone {
    display: none;
    }

    /* L'afficher uniquement sur les petits et moyens écrans */
    @media (max-width: 1024px) {
    .shareOnPhone {
        display: block;
    }
    }

</style>
<meta name="publication-slug" content="{{ $publication->slug }}">

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

            <!-- Dans article -->
            {{-- <x-ad-slot position="popup" :context="['rubrique_id' => $publication->rubrique_id ?? null]" /> --}}

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
                <p class="text-xl text-gray-700 leading-relaxed font-medium border-l-4 border-blue-600 pl-6 pr-4 py-4 bg-blue-50 rounded text-justify">
                    {{ $publication->excerpt }}
                </p>
            </div>
            @endif
<center><br>

                    <x-ad-slot position="popup"  :rotation="true" :interval="15000">
                        <x-slot name="fallback">
                            <div class="text-center p-4">
                                <p>Votre publicité ici</p>
                            </div>
                        </x-slot>
                    </x-ad-slot> <br>
</center>
            <!-- Content -->
            <div class="px-8 pb-8">
                <div class="prose prose-lg max-w-none  text-justify">
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
                                class="bg-gray-700 text-white px-6 py-0 rounded-lg font-semibold hover:bg-gray-800 transition shareOnPhone">
                            Plus
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Articles -->
</article>

        <!-- Related Articles -->
        @if($relatedArticles->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Articles similaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedArticles as $related)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <!-- ... contenu de l'article similaire ... -->
                </article>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Comments Section - EN DEHORS DU @ if -->
        <section class="mt-12 bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-8 py-6 border-b">
                <h2 class="text-2xl font-bold">
                    💬 Commentaires (<span id="comments-count">{{ $publication->comments_count }}</span>)
                </h2>
            </div>

            <!-- Comment Form -->
            <div class="px-8 py-6 bg-gray-50 border-b">
                <form id="comment-form" class="space-y-4">
                    @csrf

                    <!-- Message de succès -->
                    <div id="success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">Commentaire ajouté avec succès !</span>
                    </div>

                    <!-- Message d'erreur -->
                    <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline" id="error-text"></span>
                    </div>

                    <!-- Champs pour invités -->
                    <div id="guest-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Votre nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                id="guest_name"
                                name="guest_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Jean Dupont">
                            <span class="text-red-500 text-sm hidden" id="error-guest_name"></span>
                        </div>
                        <div>
                            <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Votre email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                id="guest_email"
                                name="guest_email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="jean@example.com">
                            <span class="text-red-500 text-sm hidden" id="error-guest_email"></span>
                        </div>
                    </div>

                    <!-- Champ commentaire -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Votre commentaire <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content"
                                name="content"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                placeholder="Partagez votre avis..."></textarea>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-red-500 text-sm hidden" id="error-content"></span>
                            <span class="text-sm text-gray-500" id="char-count">0 / 1000</span>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="flex justify-end">
                        <button type="submit"
                                id="submit-btn"
                                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <span id="submit-text">Publier le commentaire</span>
                            <span id="submit-loading" class="hidden">
                                <svg class="inline animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Envoi en cours...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div class="px-8 py-6">
                <div id="comments-list" class="space-y-6">
                    <!-- Les commentaires seront chargés ici via JavaScript -->
                    <div class="flex justify-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    </div>
                </div>

                <!-- Pagination -->
                <div id="comments-pagination" class="mt-6 flex justify-center">
                    <!-- Le bouton sera généré via JavaScript -->
                </div>
            </div>
        </section>

    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/comments.js') }}"></script>
@endpush

@endsection
