@extends('layouts.frontend')

@section('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')

@section('content')

<style>
    /* Style pour la scrollbar personnalisée */
    #news-scroll::-webkit-scrollbar {
        width: 6px;
    }

    #news-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #news-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    #news-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Firefox */
    #news-scroll {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f1f1;
    }

    /* Animation smooth pour le hover */
    #news-scroll article {
        transition: all 0.2s ease;
    }

    /* Responsive pour les boutons de filtres */
    @media (max-width: 640px) {
        .filter-buttons a {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }
    }

    /* Animation pour les mises à jour */
    .market-item {
        transition: background-color 0.3s ease;
    }

    /* Animation du badge de statut */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Largeur des cartes selon l'écran */
    @media (max-width: 640px) {
        .podcast-card {
            width: calc(100% - 1rem);
            min-width: calc(100% - 1rem);
        }
    }

    @media (min-width: 641px) and (max-width: 768px) {
        .podcast-card {
            width: calc(50% - 0.5rem);
            min-width: calc(50% - 0.5rem);
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .podcast-card {
            width: calc(33.333% - 0.75rem);
            min-width: calc(33.333% - 0.75rem);
        }
    }

    @media (min-width: 1025px) and (max-width: 1280px) {
        .podcast-card {
            width: calc(25% - 0.75rem);
            min-width: calc(25% - 0.75rem);
        }
    }

    @media (min-width: 1281px) {
        .podcast-card {
            width: calc(20% - 0.8rem);
            min-width: calc(20% - 0.8rem);
        }
    }

    #podcast-carousel {
        scroll-behavior: smooth;
    }

    #podcast-carousel::-webkit-scrollbar {
        display: none;
    }

    #podcast-carousel {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .container {
        max-width: 1320px;
        margin: 0 auto;
        /* padding: 0 22px */
    }
</style>

<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">

        <!-- Main Content -->
        <div class="lg:col-span-2">

            <!-- Filtres / Boutons de navigation -->
            <div class="mb-3 overflow-x-auto pb-2 filter-buttons">
                <div class="flex gap-2 min-w-max">
                    @foreach ($metaKeywords as $item)
                        <a href="{{ route('publication.show', $item->meta_title ?? '#') }}"
                        class="inline-block border border-gray-300 text-gray-800 bg-gray-100 hover:bg-blue-600 hover:text-white hover:border-blue-600 px-4 sm:px-8 py-1 rounded-full font-bold transition whitespace-nowrap">
                            {{ $item->meta_title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Lecteur Vidéo Direct YouTube -->
            <div class="bg-black rounded-lg overflow-hidden shadow-2xl mb-6 sm:mb-8 aspect-video relative">
                <iframe
                    id="youtube-player"
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/TgOshEXFrKQ?autoplay=1&mute=1&controls=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
                    title="LIGNE CLAIRE MÉDIA+ - Direct"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>

                <!-- Badge DIRECT en overlay -->
                <div class="absolute top-2 right-2 sm:top-4 sm:right-4 bg-red-600 text-white px-2 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-bold flex items-center gap-1 sm:gap-2 shadow-lg z-10 pointer-events-none">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full animate-pulse"></span>
                    DIRECT
                </div>
            </div>

            <!-- Article à la Une -->
            @if($featuredArticle)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 sm:mb-8 hover:shadow-xl transition">
                <div class="h-48 sm:h-64 md:h-80 lg:h-96 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center relative">
                    @if($featuredArticle->featured_image)
                        <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}"
                             alt="{{ $featuredArticle->title }}"
                             class="w-full h-full object-cover">
                    @endif
                    <span class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-blue-600 text-white px-2 py-1 sm:px-4 sm:py-2 rounded font-bold text-xs uppercase">
                        À LA UNE
                    </span>
                    @if($featuredArticle->is_new)
                    <span class="absolute top-2 right-2 sm:top-4 sm:right-4 bg-red-600 text-white px-2 py-1 sm:px-3 sm:py-1 rounded font-bold text-xs uppercase animate-pulse">
                        NEW
                    </span>
                    @endif
                </div>
                <div class="p-4 sm:p-6 lg:p-8">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-3 sm:mb-4 leading-tight hover:text-blue-600 transition">
                        <a href="{{ route('publication.show', $featuredArticle->slug) }}">
                            {{ $featuredArticle->title }}
                        </a>
                    </h1>
                    <div class="flex flex-wrap gap-3 sm:gap-6 text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">
                        <span>👤 {{ $featuredArticle->user->public_name }}</span>
                        <span>📅 {{ $featuredArticle->formatted_published_date }}</span>
                        <span>👁️ {{ number_format($featuredArticle->views_count) }} vues</span>
                    </div>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 sm:mb-6 line-clamp-3 sm:line-clamp-none text-justify">
                        {{ $featuredArticle->excerpt }}
                    </p>
                    <a href="{{ route('publication.show', $featuredArticle->slug) }}"
                       class="inline-block bg-blue-600 text-white px-6 sm:px-8 py-2 rounded-full font-bold hover:bg-blue-700 transition text-sm sm:text-base">
                        Lire l'article complet →
                    </a>
                </div>
            </article>
            @endif

            <!-- Actualités du jour -->
            <section class="mb-8 sm:mb-12">
                <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 pl-3 sm:pl-4 border-l-4 border-blue-600">
                    Actualités du jour
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($recentArticles as $article)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 sm:hover:-translate-y-2 transition cursor-pointer">
                        <a href="{{ route('publication.show', $article->slug) }}">
                            <div class="h-40 sm:h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-4xl sm:text-5xl">📰</span>
                                @endif
                                @if($article->is_new)
                                <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                                    NEW
                                </span>
                                @endif
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="text-blue-600 text-xs font-bold uppercase mb-2">
                                    {{ $article->rubrique->name }}
                                </div>
                                <h3 class="text-base sm:text-lg font-bold mb-2 sm:mb-3 leading-tight line-clamp-1 h-30">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                    {{ $article->excerpt }}
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-500 pt-3 sm:pt-4 border-t">
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
        <aside class="space-y-4 sm:space-y-5 lg:w-auto">

            <!-- Bouton Acheter le journal -->
            <div class="w-full">
                <a href="{{ route('shop.index') }}"
                   class="block bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg font-bold text-sm uppercase text-center w-full transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    📰 Acheter le journal
                </a>
            </div>

            <!-- Section NEWS 24/7 avec scroll vertical -->
            <div class="bg-gray-200 rounded-lg shadow-lg overflow-hidden" style="min-height: 100vh">
                <!-- Header NEWS 24/7 -->
                <div class="bg-red-600 text-white px-3 py-2 w-full sm:w-auto sm:inline-block">
                    <h3 class="font-black text-base sm:text-lg uppercase tracking-wide">NEWS 24/7</h3>
                </div>

                <!-- Zone scrollable -->
                <div class="overflow-y-auto max-h-[800px] sm:max-h-[1200px] scroll-smooth p-2 sm:p-3 bg-gray-200" id="news-scroll">
                    <div class="space-y-2 sm:space-y-3">
                        @foreach($recentArticles->take(30) as $article)
                        <article class="p-3 sm:p-4 hover:bg-gray-100 bg-white transition cursor-pointer rounded">
                            <a href="{{ route('publication.show', $article->slug) }}" class="block">
                                <!-- Timestamp -->
                                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $article->published_at->format('H\hi') }}</span>
                                </div>

                                <!-- Titre -->
                                <h4 class="font-bold text-xs sm:text-sm leading-tight mb-2 sm:mb-3 line-clamp-2 hover:text-blue-600 transition">
                                    {{ $article->title }}
                                </h4>

                                <!-- Image + Texte -->
                                <div class="flex gap-2 sm:gap-3">
                                    <!-- Miniature -->
                                    <div class="relative flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gray-200 rounded overflow-hidden">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                 alt="{{ $article->title }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
                                                <span class="text-white text-xl sm:text-2xl">📰</span>
                                            </div>
                                        @endif

                                        <!-- Play button si vidéo -->
                                        @if($article->has_video ?? false)
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-white/90 rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Texte d'aperçu -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-600 text-xs leading-relaxed line-clamp-3 sm:line-clamp-4">
                                            {{ Str::limit($article->excerpt ?? $article->content, 120) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @endforeach
                    </div>
                </div>

                <!-- Footer "Toute l'actualité" -->
                <div class="bg-gray-400 border-t border-gray-200">
                    <a href="{{ route('home') }}"
                       class="block text-center py-2 sm:py-3 font-bold text-xs sm:text-sm hover:bg-gray-200 transition text-white">
                        Toute l'actualité
                    </a>
                </div>
            </div>

            <!-- Les + Lus -->
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                <h3 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4 pb-3 sm:pb-4 border-b-2 border-blue-600">
                    🔥 Les + Lus
                </h3>
                @foreach($popularArticles->take(3) as $index => $popular)
                <div class="flex gap-3 sm:gap-4 py-3 sm:py-4 border-b last:border-0 hover:bg-gray-50 cursor-pointer transition">
                    <div class="text-2xl sm:text-3xl font-bold text-blue-600 min-w-[30px] sm:min-w-[40px]">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('publication.show', $popular->slug) }}">
                            <h4 class="font-semibold text-xs sm:text-sm leading-tight mb-1 sm:mb-2 hover:text-blue-600 line-clamp-2">
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

            <!-- Marchés Financiers - Widget avec mise à jour automatique -->
            <div class="hidden sm:block bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b-2 border-blue-600">
                    <h3 class="text-xl font-bold">
                        📈 Marchés Financiers
                    </h3>
                    <div class="flex items-center gap-2">
                        <span id="market-status" class="text-xs text-green-600 font-semibold flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-600 rounded-full animate-pulse"></span>
                            En direct
                        </span>
                    </div>
                </div>

                <div class="space-y-4" id="market-data">
                    <!-- CAC 40 -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">CAC 40</div>
                            <div class="font-bold text-lg" data-market="cac40-price">
                                {{ $marketData['cac40']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="cac40-badge"
                                data-positive="{{ ($marketData['cac40']['is_positive'] ?? true) ? 'true' : 'false' }}">
                                <span data-market="cac40-change">
                                    {{ ($marketData['cac40']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['cac40']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="cac40-change-value">
                                {{ ($marketData['cac40']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['cac40']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>

                    <!-- DOW JONES -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">DOW JONES</div>
                            <div class="font-bold text-lg" data-market="dowjones-price">
                                {{ $marketData['dowjones']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="dowjones-badge"
                                data-positive="{{ ($marketData['dowjones']['is_positive'] ?? true) ? 'true' : 'false' }}">
                                <span data-market="dowjones-change">
                                    {{ ($marketData['dowjones']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['dowjones']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="dowjones-change-value">
                                {{ ($marketData['dowjones']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['dowjones']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>

                    <!-- EUR/USD -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">EUR/USD</div>
                            <div class="font-bold text-lg" data-market="eurusd-price">
                                {{ $marketData['eurusd']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="eurusd-badge"
                                data-positive="{{ ($marketData['eurusd']['is_positive'] ?? false) ? 'true' : 'false' }}">
                                <span data-market="eurusd-change">
                                    {{ ($marketData['eurusd']['is_positive'] ?? false) ? '+' : '-' }}{{ $marketData['eurusd']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="eurusd-change-value">
                                {{ ($marketData['eurusd']['is_positive'] ?? false) ? '+' : '-' }}{{ $marketData['eurusd']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>

                    <!-- Avant le bloc BRVM Composite -->
                    <div class="bg-gradient-to-r from-green-600 to-yellow-500 text-white px-3 py-2 rounded-lg mb-3">
                        <p class="text-xs font-bold uppercase text-center">
                            🌍 Bourses Régionales d'Afrique
                        </p>
                    </div>

                    <!-- BRVM Composite -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">BRVM Composite</div>
                            <div class="font-bold text-lg" data-market="brvm_composite-price">
                                {{ $marketData['brvm_composite']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="brvm_composite-badge"
                                data-positive="{{ ($marketData['brvm_composite']['is_positive'] ?? true) ? 'true' : 'false' }}">
                                <span data-market="brvm_composite-change">
                                    {{ ($marketData['brvm_composite']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_composite']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_composite-change-value">
                                {{ ($marketData['brvm_composite']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_composite']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>

                    <!-- BRVM 30 -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">BRVM 30</div>
                            <div class="font-bold text-lg" data-market="brvm_30-price">
                                {{ $marketData['brvm_30']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="brvm_30-badge"
                                data-positive="{{ ($marketData['brvm_30']['is_positive'] ?? true) ? 'true' : 'false' }}">
                                <span data-market="brvm_30-change">
                                    {{ ($marketData['brvm_30']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_30']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_30-change-value">
                                {{ ($marketData['brvm_30']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_30']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>

                    <!-- BRVM Prestige -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                        <div>
                            <div class="font-semibold text-sm">BRVM Prestige</div>
                            <div class="font-bold text-lg" data-market="brvm_prestige-price">
                                {{ $marketData['brvm_prestige']['price'] ?? 'Chargement...' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block px-3 py-1 rounded text-sm font-bold"
                                data-market="brvm_prestige-badge"
                                data-positive="{{ ($marketData['brvm_prestige']['is_positive'] ?? true) ? 'true' : 'false' }}">
                                <span data-market="brvm_prestige-change">
                                    {{ ($marketData['brvm_prestige']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_prestige']['change_percent'] ?? '0.00' }}%
                                </span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_prestige-change-value">
                                {{ ($marketData['brvm_prestige']['is_positive'] ?? true) ? '+' : '-' }}{{ $marketData['brvm_prestige']['change'] ?? '0.00' }}
                            </span>
                        </div>
                    </div>


                </div>

                <!-- Footer avec dernière mise à jour -->
                <div class="text-xs text-gray-400 text-center mt-4 pt-3 border-t flex items-center justify-center gap-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span id="last-update">
                        Mis à jour : {{ now()->format('H:i:s') }}
                    </span>
                </div>
            </div>


            <!-- Newsletter -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-4 sm:p-6">
                <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3">
                    📧 Newsletter
                </h3>
                <p class="text-xs sm:text-sm mb-3 sm:mb-4 text-blue-100">
                    Recevez l'essentiel de l'actualité directement dans votre boîte mail.
                </p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="email"
                           name="email"
                           placeholder="Votre adresse email"
                           required
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm">
                    <button type="submit"
                            class="w-full bg-white text-blue-600 px-3 sm:px-4 py-2 sm:py-3 rounded-lg font-bold hover:bg-blue-50 transition text-sm">
                        S'abonner
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<!-- Section Politique -->
<section class="py-8 sm:py-12 lg:py-16 my-8 sm:my-8 lg:my-8">
    <div class="container mx-auto px-2 sm:px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4">
            {{-- <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black uppercase relative pl-4 sm:pl-6 before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1 sm:before:w-1.5 before:h-8 sm:before:h-12 before:bg-gradient-to-b before:from-red-600 before:to-blue-600 before:rounded">
                Politique
            </h2> --}}
                <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 pl-3 sm:pl-4 border-l-4 border-blue-600">
                    Politique
                </h2>
            <a href="{{ route('rubrique.show', 'politique') }}"
               class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-full font-bold text-xs sm:text-sm uppercase hover:bg-blue-700 transition shadow-lg">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($politiqueArticles as $article)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-1 sm:hover:-translate-y-2 transition">
                <a href="{{ route('publication.show', $article->slug) }}">
                    <div class="h-32 sm:h-40 bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-3xl sm:text-4xl">🏛️</span>
                        @endif
                    </div>
                    <div class="p-4 sm:p-5">
                        <h3 class="font-bold text-sm sm:text-base leading-tight mb-2 sm:mb-3 line-clamp-2">
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

<!-- Section Podcasts - Style exact de l'image -->
<section class="py-8 sm:py-12 lg:py-16">
    <div class="container mx-auto px-2 sm:px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            {{-- <h2 class="text-2xl sm:text-3xl font-black uppercase">
                PODCASTS
            </h2> --}}
                <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 pl-3 sm:pl-4 border-l-4 border-blue-600">
                    PODCASTS
                </h2>
            <div class="flex items-center gap-4">
                <a
                    href="#"
                    {{-- href="{{ route('podcasts.index') }}" --}}
                   class="text-gray-500 hover:text-gray-700 font-semibold text-sm uppercase transition hidden sm:block">
                    TOUS LES PODCASTS
                </a>
                <div class="flex gap-2">
                    <button id="podcast-prev"
                            class="w-9 h-9 rounded-full border border-gray-300 hover:border-gray-400 flex items-center justify-center transition bg-white">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button id="podcast-next"
                            class="w-9 h-9 rounded-full border border-gray-300 hover:border-gray-400 flex items-center justify-center transition bg-white">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Carrousel -->
        <div class="relative overflow-hidden -mx-2 sm:mx-0">
            <div id="podcast-carousel" class="flex transition-transform duration-500 ease-out px-2 sm:px-0" style="gap: 1rem;">

                @php
                    $podcasts = [
                        [
                            'title' => '1960-1974: Une éducation politique',
                            'duration' => '45:08',
                            'image' => 'podcast1.jpg',
                            'bg_color' => 'bg-gradient-to-br from-pink-300 via-purple-300 to-blue-400',
                        ],
                        [
                            'title' => '"Ils reviennent!": la libération des otages israéliens annonce-t-elle la fin de la guerre à Gaza?',
                            'duration' => '17:09',
                            'image' => 'podcast2.jpg',
                            'bg_color' => 'bg-gradient-to-br from-orange-400 to-yellow-300',
                        ],
                        [
                            'title' => 'Quels sont les critères pour entrer au Panthéon?',
                            'duration' => '2:59',
                            'image' => 'podcast3.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-500 to-pink-500',
                        ],
                        [
                            'title' => 'Pourquoi le marché de la seconde main explose-t-il?',
                            'duration' => '2:45',
                            'image' => 'podcast4.jpg',
                            'bg_color' => 'bg-gradient-to-br from-cyan-400 to-blue-500',
                        ],
                        [
                            'title' => 'Notre corps peut-il s\'adapter à des températures de 50°C?',
                            'duration' => '13:57',
                            'image' => 'podcast5.jpg',
                            'bg_color' => 'bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400',
                        ],
                        [
                            'title' => '7 MINUTES POUR COMPRENDRE : Chine, défilé militaire ou une menace envers Trump?',
                            'duration' => '6:14',
                            'image' => 'podcast6.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-600 to-orange-400',
                        ],
                        [
                            'title' => '1960-1974: Une éducation politique',
                            'duration' => '45:08',
                            'image' => 'podcast1.jpg',
                            'bg_color' => 'bg-gradient-to-br from-pink-300 via-purple-300 to-blue-400',
                        ],
                        [
                            'title' => '"Ils reviennent!": la libération des otages israéliens annonce-t-elle la fin de la guerre à Gaza?',
                            'duration' => '17:09',
                            'image' => 'podcast2.jpg',
                            'bg_color' => 'bg-gradient-to-br from-orange-400 to-yellow-300',
                        ],
                        [
                            'title' => 'Quels sont les critères pour entrer au Panthéon?',
                            'duration' => '2:59',
                            'image' => 'podcast3.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-500 to-pink-500',
                        ],
                        [
                            'title' => 'Pourquoi le marché de la seconde main explose-t-il?',
                            'duration' => '2:45',
                            'image' => 'podcast4.jpg',
                            'bg_color' => 'bg-gradient-to-br from-cyan-400 to-blue-500',
                        ],
                        [
                            'title' => 'Notre corps peut-il s\'adapter à des températures de 50°C?',
                            'duration' => '13:57',
                            'image' => 'podcast5.jpg',
                            'bg_color' => 'bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400',
                        ],
                        [
                            'title' => '7 MINUTES POUR COMPRENDRE : Chine, défilé militaire ou une menace envers Trump?',
                            'duration' => '6:14',
                            'image' => 'podcast6.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-600 to-orange-400',
                        ],
                        [
                            'title' => '1960-1974: Une éducation politique',
                            'duration' => '45:08',
                            'image' => 'podcast1.jpg',
                            'bg_color' => 'bg-gradient-to-br from-pink-300 via-purple-300 to-blue-400',
                        ],
                        [
                            'title' => '"Ils reviennent!": la libération des otages israéliens annonce-t-elle la fin de la guerre à Gaza?',
                            'duration' => '17:09',
                            'image' => 'podcast2.jpg',
                            'bg_color' => 'bg-gradient-to-br from-orange-400 to-yellow-300',
                        ],
                        [
                            'title' => 'Quels sont les critères pour entrer au Panthéon?',
                            'duration' => '2:59',
                            'image' => 'podcast3.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-500 to-pink-500',
                        ],
                        [
                            'title' => 'Pourquoi le marché de la seconde main explose-t-il?',
                            'duration' => '2:45',
                            'image' => 'podcast4.jpg',
                            'bg_color' => 'bg-gradient-to-br from-cyan-400 to-blue-500',
                        ],
                        [
                            'title' => 'Notre corps peut-il s\'adapter à des températures de 50°C?',
                            'duration' => '13:57',
                            'image' => 'podcast5.jpg',
                            'bg_color' => 'bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400',
                        ],
                        [
                            'title' => '7 MINUTES POUR COMPRENDRE : Chine, défilé militaire ou une menace envers Trump?',
                            'duration' => '6:14',
                            'image' => 'podcast6.jpg',
                            'bg_color' => 'bg-gradient-to-br from-purple-600 to-orange-400',
                        ],
                    ];
                @endphp

                @foreach($podcasts as $index => $podcast)
                <article class="podcast-card flex-shrink-0 cursor-pointer group">
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow">
                        <!-- Image avec bouton play -->
                        <div class="relative {{ $podcast['bg_color'] }} h-44 flex items-center justify-center overflow-hidden">
                            @if(isset($podcast['image']) && file_exists(public_path('storage/' . $podcast['image'])))
                                <img src="{{ asset('storage/' . $podcast['image']) }}"
                                     alt="{{ $podcast['title'] }}"
                                     class="w-full h-full object-cover">
                            @endif

                            <!-- Bouton Play centré -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-gray-800 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Badge durée en haut à droite -->
                            <div class="absolute top-2 right-2 bg-white text-gray-800 px-2 py-0.5 rounded text-xs font-semibold">
                                {{ $podcast['duration'] }}
                            </div>
                        </div>

                        <!-- Titre -->
                        <div class="p-4">
                            <h3 class="text-sm font-bold leading-tight line-clamp-3 min-h-[3.6rem]">
                                {{ $podcast['title'] }}
                            </h3>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>
        </div>
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
    }
</script>

<script>
    // Configuration
    const MARKET_CONFIG = {
        updateInterval: 30000, // Mise à jour toutes les 30 secondes
        apiEndpoint: '/api/market-data',
        animationDuration: 300
    };

    // État
    let updateTimer = null;
    let isUpdating = false;

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔄 Démarrage des mises à jour automatiques des marchés...');
        startAutoUpdate();

        // Première mise à jour après 5 secondes
        setTimeout(updateMarketData, 5000);
    });

    // Démarrer les mises à jour automatiques
    function startAutoUpdate() {
        if (updateTimer) {
            clearInterval(updateTimer);
        }

        updateTimer = setInterval(updateMarketData, MARKET_CONFIG.updateInterval);
    }

    // Arrêter les mises à jour (si nécessaire)
    function stopAutoUpdate() {
        if (updateTimer) {
            clearInterval(updateTimer);
            updateTimer = null;
        }
    }

    // Fonction principale de mise à jour
    async function updateMarketData() {
        if (isUpdating) {
            console.log('⏳ Mise à jour déjà en cours...');
            return;
        }

        isUpdating = true;
        updateStatus('updating');

        try {
            const response = await fetch(MARKET_CONFIG.apiEndpoint, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success && result.data) {
                updateMarketWidget(result.data);
                updateLastUpdateTime(result.updated_at);
                updateStatus('success');
                console.log('✅ Données mises à jour avec succès');
            } else {
                throw new Error('Données invalides reçues de l\'API');
            }
        } catch (error) {
            console.error('❌ Erreur lors de la mise à jour:', error);
            updateStatus('error');
        } finally {
            isUpdating = false;
        }
    }

    // Mise à jour du widget avec les nouvelles données
    function updateMarketWidget(data) {
        const markets = ['cac40', 'dowjones', 'eurusd', 'brvm_composite', 'brvm_30', 'brvm_prestige'];

        markets.forEach(market => {
            if (data[market]) {
                animateUpdate(market, data[market]);
            }
        });
    }

    // Animation de mise à jour avec effet de pulsation
    function animateUpdate(market, marketData) {
        const priceElement = document.querySelector(`[data-market="${market}-price"]`);
        const changeElement = document.querySelector(`[data-market="${market}-change"]`);
        const changeValueElement = document.querySelector(`[data-market="${market}-change-value"]`);
        const badgeElement = document.querySelector(`[data-market="${market}-badge"]`);

        if (!priceElement) return;

        // Animation de pulsation
        const item = priceElement.closest('.market-item');
        item.classList.add('bg-blue-50');

        setTimeout(() => {
            // Mise à jour du prix
            priceElement.textContent = marketData.price;

            // Mise à jour du pourcentage de variation
            const sign = marketData.is_positive ? '+' : '-';
            if (changeElement) {
                changeElement.textContent = `${sign}${marketData.change_percent}%`;
            }

            // Mise à jour de la variation en valeur absolue
            if (changeValueElement) {
                changeValueElement.textContent = `${sign}${marketData.change}`;
            }

            // Mise à jour du badge (couleur)
            if (badgeElement) {
                badgeElement.setAttribute('data-positive', marketData.is_positive);

                // Suppression des anciennes classes
                badgeElement.classList.remove('text-green-600', 'bg-green-100', 'text-red-600', 'bg-red-100');

                // Ajout des nouvelles classes
                if (marketData.is_positive) {
                    badgeElement.classList.add('text-green-600', 'bg-green-100');
                } else {
                    badgeElement.classList.add('text-red-600', 'bg-red-100');
                }
            }

            item.classList.remove('bg-blue-50');
        }, MARKET_CONFIG.animationDuration);
    }

    // Mise à jour du statut visuel
    function updateStatus(status) {
        const statusElement = document.getElementById('market-status');
        if (!statusElement) return;

        const dot = statusElement.querySelector('span');

        switch(status) {
            case 'updating':
                statusElement.innerHTML = `
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                    Mise à jour...
                `;
                statusElement.className = 'text-xs text-blue-600 font-semibold flex items-center gap-1';
                break;
            case 'success':
                statusElement.innerHTML = `
                    <span class="w-2 h-2 bg-green-600 rounded-full animate-pulse"></span>
                    En direct
                `;
                statusElement.className = 'text-xs text-green-600 font-semibold flex items-center gap-1';
                break;
            case 'error':
                statusElement.innerHTML = `
                    <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                    Hors ligne
                `;
                statusElement.className = 'text-xs text-red-600 font-semibold flex items-center gap-1';
                break;
        }
    }

    // Mise à jour de l'horodatage
    function updateLastUpdateTime(timeString) {
        const lastUpdateElement = document.getElementById('last-update');
        if (lastUpdateElement) {
            lastUpdateElement.textContent = `Mis à jour : ${timeString || new Date().toLocaleTimeString('fr-FR')}`;
        }
    }

    // Arrêter les mises à jour quand l'utilisateur quitte la page
    window.addEventListener('beforeunload', function() {
        stopAutoUpdate();
    });

    // Reprendre les mises à jour quand l'utilisateur revient sur l'onglet
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            console.log('⏸️ Page cachée, pause des mises à jour');
            stopAutoUpdate();
        } else {
            console.log('▶️ Page visible, reprise des mises à jour');
            updateMarketData(); // Mise à jour immédiate
            startAutoUpdate();
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('podcast-carousel');
        const prevBtn = document.getElementById('podcast-prev');
        const nextBtn = document.getElementById('podcast-next');

        if (!carousel || !prevBtn || !nextBtn) return;

        const cards = carousel.querySelectorAll('.podcast-card');
        let currentIndex = 0;

        function getVisibleCards() {
            const width = window.innerWidth;
            if (width < 641) return 1;
            if (width < 769) return 2;
            if (width < 1025) return 3;
            if (width < 1281) return 4;
            return 5;
        }

        function getCardWidth() {
            if (cards.length === 0) return 0;
            const card = cards[0];
            const style = window.getComputedStyle(card);
            const marginRight = parseFloat(style.marginRight) || 16;
            return card.offsetWidth + marginRight;
        }

        function updateCarousel() {
            const cardWidth = getCardWidth();
            const offset = currentIndex * cardWidth;
            carousel.style.transform = `translateX(-${offset}px)`;

            const maxIndex = Math.max(0, cards.length - getVisibleCards());
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;

            prevBtn.style.opacity = prevBtn.disabled ? '0.3' : '1';
            nextBtn.style.opacity = nextBtn.disabled ? '0.3' : '1';
            prevBtn.style.cursor = prevBtn.disabled ? 'not-allowed' : 'pointer';
            nextBtn.style.cursor = nextBtn.disabled ? 'not-allowed' : 'pointer';
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', () => {
            const maxIndex = Math.max(0, cards.length - getVisibleCards());
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Swipe sur mobile
        let startX = 0;
        let isDragging = false;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        carousel.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;

            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextBtn.click();
                } else {
                    prevBtn.click();
                }
            }
        });

        // Resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                currentIndex = 0;
                updateCarousel();
            }, 250);
        });

        updateCarousel();
    });
</script>
@endsection
