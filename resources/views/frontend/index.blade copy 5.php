@extends('layouts.frontend')
@section('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')
@section('content')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Hero Section avec Swiper */
        .hero-section {
            position: relative;
            height: 70vh;
            min-height: 600px;
            overflow: hidden;
        }

        .heroSwiper {
            width: 100%;
            height: 100%;
        }

        .hero-slide-link {
            display: block;
            width: 100%;
            height: 100%;
        }

        .hero-slide-bg {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #6b21a8 100%);
            background-size: cover;
            background-position: center;
        }

        .hero-overlay-dark {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.3) 0%, transparent 50%);
            z-index: 2;
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

        /* Swiper Navigation personnalisée */
        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Swiper Pagination personnalisée */
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        /* Decorative circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
            z-index: 3;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }

            50% {
                transform: translate(30px, -30px) scale(1.1);
                opacity: 0.5;
            }
        }

        .circle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 30%;
            left: 15%;
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 180px;
            height: 180px;
            top: 40%;
            right: 20%;
            animation-delay: 1s;
        }

        .circle:nth-child(5) {
            width: 120px;
            height: 120px;
            bottom: 20%;
            right: 15%;
            animation-delay: 3s;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .swiper-button-next,
            .swiper-button-prev {
                width: 40px;
                height: 40px;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 16px;
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

        #news-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f1f1;
        }

        .container {
            max-width: 1320px;
            margin: 0 auto;
        }
    </style>
    @if (session('newsletter_success') || session('newsletter_error') || session('newsletter_info') || $errors->has('email'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('newsletter_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès !',
                        text: '{{ session('newsletter_success') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                @elseif (session('newsletter_error') || $errors->has('email'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: '{{ session('newsletter_error') ?? $errors->first('email') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                    });
                @elseif (session('newsletter_info'))
                    Swal.fire({
                        icon: 'info',
                        title: 'Information',
                        text: '{{ session('newsletter_info') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                    });
                @endif
            });
        </script>
    @endif
    <section class="hero-section">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @foreach ($featuredArticles as $featuredArticle)
                    <div class="swiper-slide">
                        <div class="hero-slide-bg"
                            @if ($featuredArticle->featured_image) @php
                                $extension = pathinfo($featuredArticle->featured_image, PATHINFO_EXTENSION);
                                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                            @endphp
                            @if ($isVideo)
                                style="background: #000;">
                                <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                                    <source src="{{ asset('storage/' . $featuredArticle->featured_image) }}" type="video/{{ $extension }}">
                                </video>
                                <!-- Play Button miniature -->
                                <div class="video-overlay">
                                    <div class="play-button" style="width: 120px; height: 120px;">
                                        <svg fill="currentColor" viewBox="0 0 20 20"
                                            style="width: 56px; height: 56px;">
                                            <path
                                            d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                style="background-image: url('{{ asset('storage/' . $featuredArticle->featured_image) }}');" @endif
                            @endif>
                            <a href="{{ route('publication.show', $featuredArticle->slug) }}" class="hero-tab active">

                                <!-- Afficher l'icône si pas d'image -->
                                @if (!$featuredArticle->featured_image)
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-600 to-purple-600">
                                        <span class="text-white text-9xl opacity-30">
                                            {{ $featuredArticle->rubrique->icon ?? '📰' }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Dark overlay -->
                                <div class="hero-overlay-dark"></div>
                                <!-- Decorative circles -->
                                <div class="circle"></div>
                                <div class="circle"></div>
                                <div class="circle"></div>
                                <div class="circle"></div>
                                <div class="circle"></div>
                                <!-- Gradient overlay -->
                                <div class="hero-overlay"></div>
                                <!-- Content -->

                                <div class="hero-content">
                                    <span class="hero-category">{{ $featuredArticle->rubrique->name }}</span>
                                    <div class="hero-date">
                                        {{ $featuredArticle->published_at->locale('fr')->isoFormat('DD MMMM YYYY - HH[H]mm') }}
                                    </div>
                                    <h1 class="hero-title">{{ $featuredArticle->title }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Main Content -->
    <div class="container mx-auto px-2 sm:px-4 py-8 sm:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

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
            <!-- Main Content -->
            <div class="lg:col-span-2">
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
                                        class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative video-container">
                                        @if ($article->featured_image)
                                            @php
                                                $extension = pathinfo($article->featured_image, PATHINFO_EXTENSION);
                                                $isVideo = in_array(strtolower($extension), [
                                                    'mp4',
                                                    'mov',
                                                    'avi',
                                                    'webm',
                                                ]);
                                            @endphp
                                            @if ($isVideo)
                                                <video autoplay muted loop class="w-full h-full object-cover" muted>
                                                    <source src="{{ asset('storage/' . $article->featured_image) }}"
                                                        type="video/{{ $extension }}">
                                                </video>
                                                <!-- Badge VIDEO -->
                                                <span class="video-badge">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                    </svg>
                                                    VIDÉO
                                                </span>
                                                <!-- Play Button Overlay -->
                                                <div class="video-overlay">
                                                    <div class="play-button">
                                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                    alt="{{ $article->title }}" class="w-full h-full object-cover">
                                            @endif
                                        @else
                                            <span class="text-white text-5xl">📰</span>
                                        @endif
                                        {{-- @if ($article->is_new)
                            <span
                            class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                            NEW
                            </span>
                        @endif --}}
                                        @if ($article->published_at && $article->published_at->gt(now()->subHours(12)))
                                            <span
                                                class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">NEW</span>
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
                                            {{-- {{ $article->excerpt }} --}}
                                            {{ strip_tags(preg_replace('/\s+/', ' ', $article->excerpt)) }}
                                        </p>
                                        <div class="flex justify-between items-center text-xs text-gray-500 pt-4 border-t">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $article->published_at->diffForHumans() }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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
                                        <h4
                                            class="font-bold text-sm leading-tight mb-3 line-clamp-2 hover:text-blue-600 transition">
                                            {{ $article->title }}
                                        </h4>
                                        <!-- Image + Texte -->
                                        <div class="flex gap-3">
                                            <!-- Miniature -->
                                            <div
                                                class="relative flex-shrink-0 w-24 h-24 bg-gray-200 rounded overflow-hidden video-container">
                                                @if ($article->featured_image)
                                                    @php
                                                        $extension = pathinfo(
                                                            $article->featured_image,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                        $isVideo = in_array(strtolower($extension), [
                                                            'mp4',
                                                            'mov',
                                                            'avi',
                                                            'webm',
                                                        ]);
                                                    @endphp
                                                    @if ($isVideo)
                                                        <video autoplay muted loop class="w-full h-full object-cover" muted>
                                                            <source
                                                                src="{{ asset('storage/' . $article->featured_image) }}"
                                                                type="video/{{ $extension }}">
                                                        </video>
                                                        <!-- Play Button miniature -->
                                                        <div class="video-overlay">
                                                            <div class="play-button" style="width: 30px; height: 30px;">
                                                                <svg fill="currentColor" viewBox="0 0 20 20"
                                                                    style="width: 14px; height: 14px;">
                                                                    <path
                                                                        d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                            alt="{{ $article->title }}"
                                                            class="w-full h-full object-cover">
                                                    @endif
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
                                                        <span class="text-white text-2xl">📰</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Texte d'aperçu -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-gray-600 text-xs leading-relaxed line-clamp-4">
                                                    {{-- {{ Str::limit($article->excerpt ?? $article->content, 120) }} --}}
                                                    {{ Str::limit(strip_tags(preg_replace('/\s+/', ' ', $article->excerpt ?? $article->content)), 120) }}
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
                        <a href="#"
                            class="block text-center py-3 font-bold text-sm hover:bg-gray-400 transition text-white">
                            Toute l'actualité
                        </a>
                    </div>
                </div>
                <!-- Les + Lus -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 pb-4 border-b-2 border-blue-600 flex items-center gap-2">
                        <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2c1.5 3.5 3.5 5.5 7 7-3.5 1.5-5.5 3.5-7 7-1.5-3.5-3.5-5.5-7-7 3.5-1.5 5.5-3.5 7-7z" />
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
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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
                <!-- Marchés Financiers - Widget avec mise à jour automatique -->
                <div class="hidden sm:block bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b-2 border-blue-600">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Marchés Financiers
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
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">CAC 40</div>
                                <div class="font-bold text-lg" data-market="cac40-price">
                                    {{ $marketData['cac40']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="cac40-badge"
                                    data-positive="{{ $marketData['cac40']['is_positive'] ?? true ? 'true' : 'false' }}">
                                    <span data-market="cac40-change">
                                        {{ $marketData['cac40']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['cac40']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="cac40-change-value">
                                    {{ $marketData['cac40']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['cac40']['change'] ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                        <!-- DOW JONES -->
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">DOW JONES</div>
                                <div class="font-bold text-lg" data-market="dowjones-price">
                                    {{ $marketData['dowjones']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="dowjones-badge"
                                    data-positive="{{ $marketData['dowjones']['is_positive'] ?? true ? 'true' : 'false' }}">
                                    <span data-market="dowjones-change">
                                        {{ $marketData['dowjones']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['dowjones']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="dowjones-change-value">
                                    {{ $marketData['dowjones']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['dowjones']['change'] ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                        <!-- EUR/USD -->
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">EUR/USD</div>
                                <div class="font-bold text-lg" data-market="eurusd-price">
                                    {{ $marketData['eurusd']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="eurusd-badge"
                                    data-positive="{{ $marketData['eurusd']['is_positive'] ?? false ? 'true' : 'false' }}">
                                    <span data-market="eurusd-change">
                                        {{ $marketData['eurusd']['is_positive'] ?? false ? '+' : '-' }}{{ $marketData['eurusd']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="eurusd-change-value">
                                    {{ $marketData['eurusd']['is_positive'] ?? false ? '+' : '-' }}{{ $marketData['eurusd']['change'] ?? '0.00' }}
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
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">BRVM Composite</div>
                                <div class="font-bold text-lg" data-market="brvm_composite-price">
                                    {{ $marketData['brvm_composite']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="brvm_composite-badge"
                                    data-positive="{{ $marketData['brvm_composite']['is_positive'] ?? true ? 'true' : 'false' }}">
                                    <span data-market="brvm_composite-change">
                                        {{ $marketData['brvm_composite']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_composite']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_composite-change-value">
                                    {{ $marketData['brvm_composite']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_composite']['change'] ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                        <!-- BRVM 30 -->
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">BRVM 30</div>
                                <div class="font-bold text-lg" data-market="brvm_30-price">
                                    {{ $marketData['brvm_30']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="brvm_30-badge"
                                    data-positive="{{ $marketData['brvm_30']['is_positive'] ?? true ? 'true' : 'false' }}">
                                    <span data-market="brvm_30-change">
                                        {{ $marketData['brvm_30']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_30']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_30-change-value">
                                    {{ $marketData['brvm_30']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_30']['change'] ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                        <!-- BRVM Prestige -->
                        <div
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition market-item">
                            <div>
                                <div class="font-semibold text-sm">BRVM Prestige</div>
                                <div class="font-bold text-lg" data-market="brvm_prestige-price">
                                    {{ $marketData['brvm_prestige']['price'] ?? 'Chargement...' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block px-3 py-1 rounded text-sm font-bold" data-market="brvm_prestige-badge"
                                    data-positive="{{ $marketData['brvm_prestige']['is_positive'] ?? true ? 'true' : 'false' }}">
                                    <span data-market="brvm_prestige-change">
                                        {{ $marketData['brvm_prestige']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_prestige']['change_percent'] ?? '0.00' }}%
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500 mt-1 block" data-market="brvm_prestige-change-value">
                                    {{ $marketData['brvm_prestige']['is_positive'] ?? true ? '+' : '-' }}{{ $marketData['brvm_prestige']['change'] ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Footer avec dernière mise à jour -->
                    <div
                        class="text-xs text-gray-400 text-center mt-4 pt-3 border-t flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span id="last-update">
                            Mis à jour : {{ now()->format('H:i:s') }}
                        </span>
                    </div>
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
                                <div
                                    class="h-40 bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center relative video-container">
                                    @if ($article->featured_image)
                                        @php
                                            $extension = pathinfo($article->featured_image, PATHINFO_EXTENSION);
                                            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                                        @endphp
                                        @if ($isVideo)
                                            <video autoplay muted loop class="w-full h-full object-cover" muted>
                                                <source src="{{ asset('storage/' . $article->featured_image) }}"
                                                    type="video/{{ $extension }}">
                                            </video>
                                            <!-- Badge VIDEO -->
                                            <span class="video-badge">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                </svg>
                                                VIDÉO
                                            </span>
                                            <!-- Play Button Overlay -->
                                            <div class="video-overlay">
                                                <div class="play-button">
                                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        @endif
                                    @else
                                        <span class="text-white text-4xl">🏛️</span>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="font-bold text-base leading-tight mb-3 line-clamp-2">
                                        {{ $article->title }}
                                    </h3>
                                    <span class="text-xs text-gray-500 flex">
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.heroSwiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                speed: 800,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
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

            switch (status) {
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
@endsection
