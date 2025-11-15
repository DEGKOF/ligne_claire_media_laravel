@extends('layouts.frontend')

@section('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')

@section('content')

    <style>
        /* Hero Section Full Screen */
        .hero-section {
            position: relative;
            height: 75vh;
            min-height: 600px;
            background: linear-gradient(135deg, #1e3a8a 0%, #6b21a8 100%);
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.3) 0%, transparent 50%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 0 2rem;
            max-width: 1320px;
            margin: 0 auto;
        }

        .hero-category {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: bold;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }

        .hero-date {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 4rem);
            font-weight: 900;
            color: white;
            line-height: 1.2;
            margin-bottom: 2rem;
            max-width: 800px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        .play-button {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .play-button:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
        }

        .play-button svg {
            width: 40px;
            height: 40px;
            fill: #e11d48;
            margin-left: 5px;
        }

        /* Tabs at bottom */
        .hero-tabs {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 20;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
        }

        .hero-tabs-container {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .hero-tabs-container::-webkit-scrollbar {
            display: none;
        }

        .hero-tab {
            flex: 0 0 auto;
            padding: 1.5rem 2rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }

        .hero-tab:hover,
        .hero-tab.active {
            color: white;
            border-bottom-color: #e11d48;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Decorative circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
            50% { transform: translate(30px, -30px) scale(1.1); opacity: 0.5; }
        }

        .circle:nth-child(1) { width: 200px; height: 200px; top: 10%; left: 5%; animation-delay: 0s; }
        .circle:nth-child(2) { width: 150px; height: 150px; top: 20%; right: 10%; animation-delay: 2s; }
        .circle:nth-child(3) { width: 100px; height: 100px; bottom: 30%; left: 15%; animation-delay: 4s; }
        .circle:nth-child(4) { width: 180px; height: 180px; top: 40%; right: 20%; animation-delay: 1s; }
        .circle:nth-child(5) { width: 120px; height: 120px; bottom: 20%; right: 15%; animation-delay: 3s; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .play-button {
                width: 80px;
                height: 80px;
            }

            .hero-tab {
                padding: 1rem 1.5rem;
                font-size: 0.75rem;
            }
        }

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

        .container {
            max-width: 1320px;
            margin: 0 auto;
        }
    </style>

    <!-- Hero Section Full Screen -->
    <section class="hero-section">
        <!-- Decorative circles -->
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>

        <!-- Overlay -->
        <div class="hero-overlay"></div>

        <!-- Hero Content -->
        <div class="hero-content">
            @if ($featuredArticle)
                <span class="hero-category">{{ $featuredArticle->rubrique->name }}</span>
                <div class="hero-date">{{ $featuredArticle->published_at->locale('fr')->isoFormat('DD MMMM YYYY - HH[H]mm') }}</div>
                <h1 class="hero-title">{{ $featuredArticle->title }}</h1>

                <a href="{{ route('publication.show', $featuredArticle->slug) }}" class="play-button">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Tabs at bottom -->
        {{-- <div class="hero-tabs">
            <div class="hero-tabs-container">
                @if ($featuredArticle)
                    <a href="{{ route('publication.show', $featuredArticle->slug) }}" class="hero-tab active">
                        {{ Str::limit($featuredArticle->title, 60) }}
                    </a>
                @endif

                @foreach ($recentArticles->take(4) as $article)
                    <a href="{{ route('publication.show', $article->slug) }}" class="hero-tab">
                        {{ Str::limit($article->title, 60) }}
                    </a>
                @endforeach
            </div>
        </div> --}}
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-2 sm:px-4 py-8 sm:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            <!-- Main Content -->
            <div class="lg:col-span-2">

                <!-- Filtres / Boutons de navigation -->
                {{-- <div class="mb-6 overflow-x-auto pb-2 filter-buttons">
                    <div class="flex gap-2 min-w-max">
                        @foreach ($metaKeywords as $item)
                            <a href="{{ route('publication.show', $item->meta_title ?? '#') }}"
                                class="inline-block border border-gray-300 text-gray-800 bg-gray-100 hover:bg-blue-600 hover:text-white hover:border-blue-600 px-6 py-2 rounded-full font-bold transition whitespace-nowrap text-sm">
                                {{ $item->meta_title }}
                            </a>
                        @endforeach
                    </div>
                </div> --}}

                <!-- Actualités du jour -->
                <section class="mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 pl-4 border-l-4 border-blue-600">
                        Actualités du jour
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($recentArticles as $article)
                            <article
                                class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition cursor-pointer">
                                <a href="{{ route('publication.show', $article->slug) }}">
                                    <div
                                        class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                                        @if ($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-white text-5xl">📰</span>
                                        @endif
                                        @if ($article->is_new)
                                            <span
                                                class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
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
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $article->published_at->diffForHumans() }}
                                            </span>

                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                {{ $article->comments_count }}
                                            </span>
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

                <!-- Bouton Acheter le journal -->
                <div class="w-full">
                    <a href="{{ route('shop.index') }}"
                        class="block bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-lg font-bold text-sm uppercase text-center w-full transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        📰 Acheter le journal
                    </a>
                </div>

                <!-- Section NEWS 24/7 avec scroll vertical -->
                <div class="bg-gray-200 rounded-lg shadow-lg overflow-hidden" style="min-height: 100vh">
                    <!-- Header NEWS 24/7 -->
                    <div class="bg-red-600 text-white px-3 py-2">
                        <h3 class="font-black text-lg uppercase tracking-wide">NEWS 24/7</h3>
                    </div>

                    <!-- Zone scrollable -->
                    <div class="overflow-y-auto max-h-[1200px] scroll-smooth p-3 bg-gray-200" id="news-scroll">
                        <div class="space-y-3">
                            @foreach ($recentArticles->take(30) as $article)
                                <article class="p-4 hover:bg-gray-100 bg-white transition cursor-pointer rounded">
                                    <a href="{{ route('publication.show', $article->slug) }}" class="block">
                                        <!-- Timestamp -->
                                        <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $article->published_at->format('H\hi') }}</span>
                                        </div>

                                        <!-- Titre -->
                                        <h4 class="font-bold text-sm leading-tight mb-3 line-clamp-2 hover:text-blue-600 transition">
                                            {{ $article->title }}
                                        </h4>

                                        <!-- Image + Texte -->
                                        <div class="flex gap-3">
                                            <!-- Miniature -->
                                            <div class="relative flex-shrink-0 w-24 h-24 bg-gray-200 rounded overflow-hidden">
                                                @if ($article->featured_image)
                                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                        alt="{{ $article->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
                                                        <span class="text-white text-2xl">📰</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Texte d'aperçu -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-gray-600 text-xs leading-relaxed line-clamp-4">
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
                    <div class="bg-gray-500 border-t border-gray-200">
                        <a href="#" class="block text-center py-3 font-bold text-sm hover:bg-gray-400 transition text-white">
                            Toute l'actualité
                        </a>
                    </div>
                </div>

                <!-- Les + Lus -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 pb-4 border-b-2 border-blue-600 flex items-center gap-2">
                        <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c1.5 3.5 3.5 5.5 7 7-3.5 1.5-5.5 3.5-7 7-1.5-3.5-3.5-5.5-7-7 3.5-1.5 5.5-3.5 7-7z" />
                        </svg>
                        Les + Lus
                    </h3>
                    @foreach ($popularArticles->take(3) as $index => $popular)
                        <div class="flex gap-4 py-4 border-b last:border-0 hover:bg-gray-50 cursor-pointer transition">
                            <div class="text-3xl font-bold text-blue-600 min-w-[40px]">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('publication.show', $popular->slug) }}">
                                    <h4 class="font-semibold text-sm leading-tight mb-2 hover:text-blue-600 line-clamp-2">
                                        {{ $popular->title }}
                                    </h4>
                                    <span class="text-xs text-gray-500 flex">
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $popular->published_at->diffForHumans() }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Newsletter
                    </h3>
                    <p class="text-sm mb-4 text-blue-100">
                        Recevez l'essentiel de l'actualité directement dans votre boîte mail.
                    </p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" placeholder="Votre adresse email" required
                            class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm">
                        <button type="submit"
                            class="w-full bg-white text-blue-600 px-4 py-3 rounded-lg font-bold hover:bg-blue-50 transition text-sm">
                            S'abonner
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>

    <!-- Section Politique -->
    <section class="py-12 my-2">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h2 class="text-2xl font-bold pl-4 border-l-4 border-blue-600">
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

            @if ($politiqueArticles->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($politiqueArticles as $article)
                        <article
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition">
                            <a href="{{ route('publication.show', $article->slug) }}">
                                <div class="h-40 bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center">
                                    @if ($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}"
                                            alt="{{ $article->title }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-white text-4xl">🏛️</span>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="font-bold text-base leading-tight mb-3 line-clamp-2">
                                        {{ $article->title }}
                                    </h3>
                                    <span class="text-xs text-gray-500 flex">
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
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

@endsection
