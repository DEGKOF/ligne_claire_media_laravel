@extends('layouts.frontend')

@section('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Lecteur Vidéo Direct YouTube -->
            <div class="bg-black rounded-lg overflow-hidden shadow-2xl mb-8 aspect-video relative">
                <iframe
                    id="youtube-player"
                    class="w-full h-full"
                    {{-- https://www.youtube.com/live/TgOshEXFrKQ?si=V2D35L5YqTaethJg --}}
                    src="https://www.youtube.com/embed/TgOshEXFrKQ?autoplay=1&mute=1&controls=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
                    title="LIGNE CLAIRE MÉDIA+ - Direct"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>

                <!-- Badge DIRECT en overlay -->
                <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg z-10 pointer-events-none">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    DIRECT
                </div>
            </div>

            <!-- Article à la Une -->
            @if($featuredArticle)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 hover:shadow-xl transition">
                <div class="h-96 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center relative">
                    @if($featuredArticle->featured_image)
                        <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}"
                             alt="{{ $featuredArticle->title }}"
                             class="w-full h-full object-cover">
                    @endif
                    <span class="absolute top-4 left-4 bg-blue-600 text-white px-4 py-2 rounded font-bold text-xs uppercase">
                        À LA UNE
                    </span>
                    @if($featuredArticle->is_new)
                    <span class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded font-bold text-xs uppercase animate-pulse">
                        NEW
                    </span>
                    @endif
                </div>
                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-4 leading-tight hover:text-blue-600 transition">
                        <a href="{{ route('publication.show', $featuredArticle->slug) }}">
                            {{ $featuredArticle->title }}
                        </a>
                    </h1>
                    <div class="flex gap-6 text-sm text-gray-600 mb-4">
                        <span>👤 Par {{ $featuredArticle->user->public_name }}</span>
                        <span>📅 {{ $featuredArticle->formatted_published_date }}</span>
                        <span>👁️ {{ number_format($featuredArticle->views_count) }} vues</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ $featuredArticle->excerpt }}
                    </p>
                    <a href="{{ route('publication.show', $featuredArticle->slug) }}"
                       class="inline-block bg-blue-600 text-white px-8 py-2 rounded-full font-bold hover:bg-blue-700 transition">
                        Lire l'article complet →
                    </a>
                </div>
            </article>
            @endif

            <!-- Actualités du jour -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold mb-6 pl-4 border-l-4 border-blue-600">
                    Actualités du jour
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentArticles as $article)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition cursor-pointer">
                        <a href="{{ route('publication.show', $article->slug) }}">
                            <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-5xl">📰</span>
                                @endif
                                @if($article->is_new)
                                <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                                    NEW
                                </span>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-blue-600 text-xs font-bold uppercase mb-2">
                                    {{ $article->rubrique->name }}
                                </div>
                                <h3 class="text-lg font-bold mb-3 leading-tight line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $article->excerpt }}
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-500 pt-4 border-t">
                                    <span>⏱️ {{ $article->published_at->diffForHumans() }}</span>
                                    <span>💬 {{ $article->comments_count }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <aside class="space-y-6">
            <!-- Les + Lus -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4 pb-4 border-b-2 border-blue-600">
                    🔥 Les + Lus
                </h3>
                @foreach($popularArticles as $index => $popular)
                <div class="flex gap-4 py-4 border-b last:border-0 hover:bg-gray-50 cursor-pointer transition">
                    <div class="text-3xl font-bold text-blue-600 min-w-[40px]">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('publication.show', $popular->slug) }}">
                            <h4 class="font-semibold text-sm leading-tight mb-2 hover:text-blue-600">
                                {{ $popular->title }}
                            </h4>
                            <span class="text-xs text-gray-500">
                                ⏱️ {{ $popular->published_at->diffForHumans() }}
                            </span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Marchés Financiers -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4 pb-4 border-b-2 border-blue-600">
                    📈 Marchés Financiers
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <div class="font-semibold text-sm">CAC 40</div>
                            <div class="font-bold text-lg">7 482.35</div>
                        </div>
                        <span class="text-green-600 bg-green-100 px-3 py-1 rounded text-sm font-bold">
                            +1.24%
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <div class="font-semibold text-sm">DOW JONES</div>
                            <div class="font-bold text-lg">34 876.21</div>
                        </div>
                        <span class="text-green-600 bg-green-100 px-3 py-1 rounded text-sm font-bold">
                            +0.87%
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <div class="font-semibold text-sm">EUR/USD</div>
                            <div class="font-bold text-lg">1.0945</div>
                        </div>
                        <span class="text-red-600 bg-red-100 px-3 py-1 rounded text-sm font-bold">
                            -0.32%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold mb-3">
                    📧 Newsletter
                </h3>
                <p class="text-sm mb-4 text-blue-100">
                    Recevez l'essentiel de l'actualité directement dans votre boîte mail.
                </p>
                <form class="space-y-3">
                    <input type="email"
                           placeholder="Votre adresse email"
                           class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <button type="submit"
                            class="w-full bg-white text-blue-600 px-4 py-3 rounded-lg font-bold hover:bg-blue-50 transition">
                        S'abonner
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<!-- Section Politique -->
<section class="bg-gradient-to-br from-gray-50 to-gray-100 py-16 my-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-4xl font-black uppercase relative pl-6 before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-12 before:bg-gradient-to-b before:from-red-600 before:to-blue-600 before:rounded">
                Politique
            </h2>
            <a href="{{ route('rubrique.show', 'politique') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold text-sm uppercase hover:bg-blue-700 transition shadow-lg">
                Toute la Politique →
            </a>
        </div>

        @php
            $politiqueArticles = \App\Models\Publication::published()
                ->byRubrique(\App\Models\Rubrique::where('slug', 'politique')->first()?->id ?? 0)
                ->latest('published_at')
                ->take(4)
                ->get();
        @endphp

        @if($politiqueArticles->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($politiqueArticles as $article)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition">
                <a href="{{ route('publication.show', $article->slug) }}">
                    <div class="h-40 bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-4xl">🏛️</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-base leading-tight mb-3 line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <span class="text-xs text-gray-500">
                            {{ $article->published_at->diffForHumans() }}
                        </span>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
        @endif
    </div>
</section>

<script>
    // API YouTube pour contrôler le player
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            events: {
                'onReady': onPlayerReady
            }
        });
    }

    function onPlayerReady(event) {
        // La vidéo démarre automatiquement en mode muet grâce aux paramètres de l'URL
        // Pour réactiver le son, l'utilisateur peut cliquer sur l'icône de son dans le player
    }
</script>
@endsection
