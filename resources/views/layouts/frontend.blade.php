{{-- ressources.views.layouts.frontend.blade.php(voici mon fichier de layout pour les visiteurs, c'est ici le model de base pour toutes les vues qui n'ont pas besoin de connexion) --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')</title>
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'LIGNE CLAIRE MÉDIA+ - Toute l\'actualité en temps réel')">
    <meta name="keywords" content="@yield('meta_keywords', 'actualité, news, info, direct')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'LIGNE CLAIRE MÉDIA+')">
    <meta property="og:description" content="@yield('og_description', 'L\'info en continu')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-og.jpg'))">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="stylesheet" href="{{ asset('css/advertisements.css') }}"> --}}
    <script src="{{ asset('js/ad-manager.js') }}"></script>

    <!-- Styles pour les popups flash -->
    <style>
        .flash-popup {
            position: fixed;
            z-index: 9999;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .flash-popup.hidden {
            opacity: 0;
            transform: translateY(100px) scale(0.8);
            pointer-events: none;
        }

        .flash-popup.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Responsive pour les popups - MOBILE */
        @media (max-width: 640px) {
            /* Popup DON (en bas) */
            #donation-popup {
                left: 50% !important;
                right: auto !important;
                bottom: 0.5rem !important;
                transform: translateX(-50%);
                width: calc(100vw - 1rem) !important;
                max-width: 320px !important;
            }

            #donation-popup.show {
                transform: translateX(-50%) translateY(0) scale(1);
            }

            #donation-popup.hidden {
                transform: translateX(-50%) translateY(100px) scale(0.8);
            }

            /* Popup PUB (en haut, centré) */
            #ad-popup {
                left: 50% !important;
                right: auto !important;
                top: 5rem !important;
                transform: translateX(-50%);
                width: calc(100vw - 1rem) !important;
                max-width: 300px !important;
            }

            #ad-popup.show {
                transform: translateX(-50%) translateY(0) scale(1);
            }

            #ad-popup.hidden {
                transform: translateX(-50%) translateY(-100px) scale(0.8);
            }

            /* Réduire le padding */
            .flash-popup .p-6 {
                padding: 0.875rem !important;
            }

            .flash-popup .p-8 {
                padding: 1.25rem !important;
            }

            /* Réduire les titres */
            .flash-popup h3.text-2xl {
                font-size: 1.125rem !important;
                line-height: 1.5rem !important;
            }

            .flash-popup h4.text-xl {
                font-size: 1rem !important;
                line-height: 1.25rem !important;
            }

            /* Réduire les emojis */
            .flash-popup .text-4xl {
                font-size: 1.75rem !important;
            }

            .flash-popup .text-6xl {
                font-size: 2.5rem !important;
            }

            /* Réduire les textes */
            .flash-popup p.text-sm {
                font-size: 0.75rem !important;
            }

            .flash-popup p.text-xs {
                font-size: 0.625rem !important;
            }

            /* Réduire les boutons */
            .flash-popup button,
            .flash-popup a.inline-block {
                padding: 0.625rem 1rem !important;
                font-size: 0.75rem !important;
            }

            /* Réduire les inputs */
            .flash-popup input {
                padding: 0.625rem 0.875rem !important;
                font-size: 0.875rem !important;
            }

            /* Réduire la grille de montants */
            .flash-popup .grid-cols-3 button {
                padding: 0.5rem 0.625rem !important;
                font-size: 0.75rem !important;
            }

            /* Réduire les gaps */
            .flash-popup .gap-3 {
                gap: 0.5rem !important;
            }

            .flash-popup .gap-4 {
                gap: 0.625rem !important;
            }

            .flash-popup .mb-4 {
                margin-bottom: 0.75rem !important;
            }
        }

        /* Tablettes */
        @media (min-width: 641px) and (max-width: 768px) {
            #donation-popup {
                width: 340px !important;
                max-width: 90vw !important;
            }

            #ad-popup {
                width: 320px !important;
                max-width: 90vw !important;
            }
        }

        /* Desktop - tailles par défaut */
        @media (min-width: 769px) {
            #donation-popup {
                width: 384px; /* w-96 */
            }

            #ad-popup {
                width: 320px; /* w-80 */
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        #sidebar-menu {
            z-index: 9998;
        }

        #sidebar-menu.open {
            transform: translateX(0);
        }

        #sidebar-overlay {
            z-index: 9997;
        }

        #sidebar-overlay.show {
            opacity: 1;
        }

        /* Scrollbar pour le menu latéral */
        #sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #sidebar-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Scrollbar personnalisée pour la première ligne (pôles) */
        nav > div > div:first-child::-webkit-scrollbar {
            height: 3px;
        }

        nav > div > div:first-child::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        nav > div > div:first-child::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        /* Scrollbar personnalisée pour la deuxième ligne (rubriques) */
        #nav-container::-webkit-scrollbar {
            height: 4px;
        }

        #nav-container::-webkit-scrollbar-track {
            background: transparent;
        }

        #nav-container::-webkit-scrollbar-thumb {
            background-color: #2563eb;
            border-radius: 10px;
        }

        /* Animation smooth pour le scroll horizontal */
        nav > div > div:first-child,
        #nav-container {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased">

    <!-- Menu Latéral (Sidebar) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden transition-opacity duration-300"
        onclick="closeSidebar()"></div>

    <aside id="sidebar-menu"
        class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 overflow-y-auto">
        <div class="flex flex-col h-full">
            <!-- Header du menu -->
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h2 class="font-black text-xl">LIGNE CLAIRE MÉDIA+</h2>
                <button onclick="closeSidebar()" class="text-gray-600 hover:text-gray-900 text-2xl leading-none">
                    ×
                </button>
            </div>

            <!-- Contenu du menu -->
            <nav class="flex-1 p-4">
                <!-- Bénin -->
                <div class="mb-1">
                    <a href="#"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" fill="currentColor" />
                        </svg>
                        <span>Bénin</span>
                    </a>
                </div>
                <!-- Sous-région -->
                <div class="mb-1">
                    <a href="#"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 6l3-2 3 2 3-2 3 2 3-2 3 2v14l-3 2-3-2-3 2-3-2-3 2-3-2V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l3-2 3 2 3-2 3 2 3-2 3 2" />
                        </svg>
                        <span>Sous-région</span>
                    </a>
                </div>
                <!-- Afrique -->
                <div class="mb-1">
                    <a href="#"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 14l2-2 2 2 4-4M12 2v2m0 16v2m10-10h-2M4 12H2" />
                        </svg>
                        <span>Afrique</span>
                    </a>
                </div>
                <!-- International -->
                <div class="mb-1">
                    <a href="{{ route('rubrique.show', 'international') }}"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" />
                        </svg>
                        <span>International</span>
                    </a>
                </div>

                <!-- Bénin -->
                {{-- <div class="mb-1">
                    <a href="#"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" fill="currentColor" />
                        </svg>
                        <span>Bénin</span>
                    </a>
                </div> --}}

                <!-- Catégories -->
                <div class="space-y-1">
                    @php
                        $menuItems = [
                            ['icon' => 'leaf', 'label' => 'Environnement', 'slug' => 'environnement'],
                            ['icon' => 'desktop', 'label' => 'Technologie', 'slug' => 'technologie'],
                            ['icon' => 'film', 'label' => 'Culture', 'slug' => 'culture'],
                            ['icon' => 'heart', 'label' => 'Santé', 'slug' => 'sante'],
                            ['icon' => 'chart', 'label' => 'Économie', 'slug' => 'economie'],
                            ['icon' => 'trophy', 'label' => 'Sport', 'slug' => 'sport'],
                        ];
                    @endphp

                    @foreach ($menuItems as $item)
                        <a href="{{ route('rubrique.show', $item['slug']) }}"
                            class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                            @if ($item['icon'] === 'leaf')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            @elseif($item['icon'] === 'desktop')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @elseif($item['icon'] === 'film')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                            @elseif($item['icon'] === 'heart')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            @elseif($item['icon'] === 'chart')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            @elseif($item['icon'] === 'trophy')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                            @endif
                            <span class="mx-2">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
                <!-- Divider -->
                <hr class="my-2 border-gray-200">
                {{-- LCM Pub --}}
                <a href="{{ route('annonceurs') }}"
                    class="flex items-center py-2 text-blue-700 hover:text-blue-400 font-semibold transition"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                    </svg>

                    <span class="mx-2">LCM Pub</span>
                </a>

                <!-- Divider -->
                <hr class="my-2 border-gray-200">

                <div class="space-y-1">
                    {{-- soutient --}}
                    <a href="{{ route('soutient') }}"
                        class="flex items-center py-2 text-red-700 hover:text-red-400 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span class="mx-2">Soutenir le Media</span>
                    </a>
                    @php
                        $menuItems = [
                            // ['icon' => 'desktop', 'label' => 'Soutenir le Media', 'slug' => 'sport'],
                            ['icon' => 'desktop', 'label' => 'Devenir membre', 'slug' => 'sport'],
                        ];
                    @endphp

                    @foreach ($menuItems as $item)
                        <a href="{{ route('rubrique.show', $item['slug']) }}"
                            class="flex items-center py-2 text-red-700 hover:text-red-400 font-semibold transition">
                            @if ($item['icon'] === 'leaf')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            @elseif($item['icon'] === 'desktop')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                            <span class="mx-2">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>


                <!-- Divider -->
                <hr class="my-2 border-gray-200">

                <!-- Avec fallback -->
                <x-ad-slot position="popup" :rotation="true" :interval="15000">
                    <x-slot name="fallback">
                        <div class="text-center p-4">
                            <p>Votre publicité ici</p>
                        </div>
                    </x-slot>
                </x-ad-slot>

                <!-- Divider -->
                <hr class="my-2 border-gray-200">

                <!-- Section Contenus -->
                <div class="space-y-1">
                    <a href="{{ route('home') }}"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="mx-2">Articles</span>
                    </a>

                    <a href="{{ route('replay') }}"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span class="mx-2">Documentaires</span>
                    </a>

                    <a {{-- href="{{ route('podcasts.index') }}" --}}
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        <span class="mx-2">Podcast</span>
                    </a>

                    <a href="https://lnbpari.com/fr/sportsbook/upcoming"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        <span class="mx-2">Jeux concours</span>
                    </a>

                    <a href="{{ route('search') }}"
                        class="flex items-center py-2 text-gray-800 hover:text-blue-600 font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="mx-2">Rechercher</span>
                    </a>
                </div>

                <!-- Divider -->
                <hr class="my-2 border-gray-200">

                <!-- Section Autres -->
                <div class="space-y-1">
                    <a href="{{ route('annonceurs') }}"
                        class="flex items-center py-2 px-3 text-gray-500 hover:text-gray-700 text-sm font-medium transition">
                        <span>Annonceurs</span>
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    <a href="{{ route('recruitment.index') }}"
                        class="flex items-center py-2 px-3 text-gray-500 hover:text-gray-700 text-sm font-medium transition">
                        <span>Nous rejoindre</span>
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </nav>

            <!-- Sidebar -->
            {{-- <x-ad-slot position="sidebar" /> --}}

            <!-- Bannière top -->
            {{-- <x-ad-slot position="banner_top" /> --}}

            <!-- Dans article -->
            {{-- <x-ad-slot position="article" :context="['rubrique_id' => $publication->rubrique_id ?? null]" /> --}}

            <!-- Footer du menu -->
            <div class="p-4 border-t bg-gray-50">
                <button class="w-full text-center text-sm text-gray-600 hover:text-gray-800 font-medium py-2">
                    Édition béninoise
                </button>
            </div>
        </div>
    </aside>

    <!-- Top Bar -->
    <div class="bg-black text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center text-xs">
            <div class="flex gap-4 items-center">
                <span>{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY • HH:mm') }}</span>
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-blue-400 transition">Social Media</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-gradient-to-r from-blue-900 to-blue-600 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <button class="text-white text-2xl" onclick="toggleMobileMenu()">☰</button>
                    <a href="{{ route('home') }}" class="text-white text-2xl lg:text-4xl font-black tracking-wider">
                        {{-- LIGNE CLAIRE MÉDIA+ --}}
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="90" height="auto">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('search') }}" method="GET" class="w-full relative" id="searchForm">
                        <input type="text" name="q" placeholder="Rechercher une actualité..."
                            class="w-full pl-4 pr-12 py-2 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 border border-gray-200">

                        <!-- Search Icon Button -->
                        <button type="submit"
                            class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>


                <!-- Action Buttons -->
                <div class="flex gap-1 sm:gap-2 items-center">
                    <!-- Bouton Replay -->
                    <a href="{{ route('replay') }}"
                        class="bg-transparent border-2 border-white/30 text-white px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-full text-[10px] sm:text-xs uppercase font-bold hover:bg-white/10 transition flex items-center justify-center">
                        <span class="hidden sm:inline">Replay</span>
                        <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>

                    <!-- Bouton Direct -->
                    <a href="{{ route('direct') }}"
                        class="bg-red-600 border-2 border-red-600 text-white px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-full text-[10px] sm:text-xs uppercase font-bold hover:bg-red-700 transition whitespace-nowrap flex items-center gap-1">
                        {{-- <span class="inline-block w-2 h-2 bg-white rounded-full animate-pulse"></span> --}}
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 animate-pulse inline-block w-2 h-2 bg-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125Z" />
                        </svg> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>


                        <span class="hidden xs:inline sm:hidden">Dir</span>
                        <span class="hidden sm:inline">Direct</span>
                    </a>

                    @auth
                        <!-- Menu utilisateur connecté -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-1 sm:gap-2 bg-white/10 hover:bg-white/20 border-2 border-white/30 text-white px-2 sm:px-3 py-1.5 sm:py-2 rounded-full transition">
                                <!-- Avatar -->
                                <div
                                    class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-[10px] sm:text-xs relative flex-shrink-0">
                                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                                    <span
                                        class="absolute -bottom-0.5 -right-0.5 w-2 h-2 sm:w-3 sm:h-3 bg-green-500 border-2 border-blue-900 rounded-full"></span>
                                </div>

                                <!-- Prénom (caché sur mobile) -->
                                <span class="hidden lg:inline text-sm font-semibold">{{ Auth::user()->prenom }}</span>

                                <!-- Icône dropdown -->
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 hidden sm:block" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50"
                                style="display: none;">

                                <!-- En-tête du menu -->
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 text-white">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                            {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-sm truncate">{{ Auth::user()->prenom }}
                                                {{ Auth::user()->nom }}</p>
                                            <p class="text-xs text-blue-100 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Options du menu -->
                                <div class="py-2">
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                        target="_blank"
                                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            <span class="text-sm font-medium">Dashboard Admin</span>
                                        </a>
                                        <hr class="my-2">
                                    @endif
                                    @if (Auth::user()->role === 'advertiser')
                                        <a href="{{ route('advertiser.dashboard') }}"
                                        target="_blank"
                                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            <span class="text-sm font-medium">Dashboard</span>
                                        </a>
                                        <hr class="my-2">
                                    @endif

                                    <a href="#"
                                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-sm font-medium">Mon profil</span>
                                    </a>
                                </div>

                                <!-- Déconnexion -->
                                <div class="border-t border-gray-200 p-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span class="text-sm font-bold">Se déconnecter</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Bouton Connexion -->
                        <a href="{{ route('login') }}"
                            class="bg-white text-blue-900 px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-full text-[10px] sm:text-xs uppercase font-bold hover:bg-gray-100 transition whitespace-nowrap">
                            <span class="hidden sm:inline">Se connecter</span>
                            <span class="sm:hidden">Login</span>
                        </a>
                    @endauth
                </div>


            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white border-b-3 border-blue-600 shadow relative">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center gap-4">
                <!-- Zone de texte à gauche -->
                <div class="flex items-center py-3 pr-3 border-r border-gray-300 flex-shrink-0 overflow-x-auto">
                    <!-- Titre "PÔLES" fixe -->
                    <span class="text-sm font-bold text-gray-700 uppercase mr-3 whitespace-nowrap">
                        Pôles :
                    </span>

                    <!-- Liste des pôles sans répéter "Pôle" -->
                    <span class="text-m font-medium">
                        <a href="{{ route('community.index') }}"
                            class="py-3 text-sm text-blue-600 underline uppercase whitespace-nowrap hover:text-gray-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-gray-600 transition {{ request()->routeIs('community.index') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-blue-800' }}">
                            <strong>Communauté</strong>
                        </a>
                    </span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-m font-medium">
                        <a href="{{ route('investigation.index') }}"
                            class="py-3 text-sm text-blue-600 underline uppercase whitespace-nowrap hover:text-gray-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-gray-600 transition {{ request()->routeIs('investigation.index') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-blue-800' }}">
                            <strong>Investigation</strong>
                        </a>
                    </span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-m font-medium">
                        <a href="{{ route('witness.index') }}"
                            class="py-3 text-sm text-blue-600 underline uppercase whitespace-nowrap hover:text-gray-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-gray-600 transition {{ request()->routeIs('witness.index') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-blue-800' }}">
                            <strong>Témoins</strong>
                        </a>
                    </span>
                </div>


                <!-- Conteneur pour les rubriques et le bouton - Centré -->
                <div class="flex items-center flex-shrink-0" id="nav-container">
                    <!-- Lien Accueil -->
                    <a href="{{ route('home') }}"
                        class="px-4 py-3 text-sm font-semibold uppercase whitespace-nowrap hover:text-blue-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-blue-600 transition {{ request()->routeIs('home') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-gray-800' }}">
                        Accueil
                    </a>

                    <!-- Lien Acheter le journal -->
                    <a href="{{ route('shop.index') }}"
                        class="px-4 py-3 text-sm font-semibold uppercase whitespace-nowrap hover:text-blue-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-blue-600 transition {{ request()->routeIs('shop.index') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-gray-800' }}">
                        Acheter le journal
                    </a>

                    <!-- Les 5 premières rubriques -->
                    @php
                        $allRubriques = \App\Models\Rubrique::active()->ordered()->get();
                        $visibleRubriques = $allRubriques->take(5);
                        $hiddenRubriques = $allRubriques->skip(5);
                    @endphp

                    @foreach ($visibleRubriques as $rubrique)
                        <a href="{{ route('rubrique.show', $rubrique->slug) }}"
                            class="px-4 py-3 text-sm font-semibold uppercase whitespace-nowrap hover:text-blue-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-blue-600 transition {{ request()->routeIs('rubrique.show') && request()->route('slug') === $rubrique->slug ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-gray-800' }}">
                            {{ $rubrique->name }}
                        </a>
                    @endforeach

                    <!-- Bouton pour afficher le reste -->
                    @if ($hiddenRubriques->count() > 0)
                        <button id="toggle-rubriques-btn" onclick="toggleMegaMenu()"
                            class="px-4 py-3 text-blue-600 hover:text-blue-800 hover:bg-gray-50 transition flex items-center justify-center font-semibold text-sm uppercase whitespace-nowrap"
                            aria-label="Afficher toutes les rubriques">
                            <svg id="toggle-icon"
                                class="w-5 h-5 transition-transform duration-300 border border-blue-600"
                                style="border-radius: 50%; padding: 2px" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mega Menu Dropdown - Uniquement les rubriques restantes -->
        @if ($hiddenRubriques->count() > 0)
            <div id="mega-menu"
                class="hidden absolute top-full left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-50">
                <div class="container mx-auto px-4 py-6">
                    <div class="flex flex-col items-center">
                        <div class="w-full max-w-6xl">
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                                @foreach ($hiddenRubriques as $rubrique)
                                    <a href="{{ route('rubrique.show', $rubrique->slug) }}"
                                        class="group px-4 py-3 rounded-lg hover:bg-blue-50 transition flex items-center gap-2 {{ request()->routeIs('rubrique.show') && request()->route('slug') === $rubrique->slug ? 'bg-blue-50 text-blue-600' : 'text-gray-800' }}">
                                        <span class="text-blue-600 group-hover:scale-110 transition-transform">▸</span>
                                        <span class="font-semibold text-sm uppercase">{{ $rubrique->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bouton fermer -->
                        <div class="text-center mt-6 pt-4 border-t border-gray-200 w-full">
                            <button onclick="toggleMegaMenu()"
                                class="text-sm text-gray-600 hover:text-blue-600 font-semibold uppercase flex items-center gap-2 mx-auto transition">
                                <span>Fermer</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </nav>

    <!-- Overlay pour fermer le menu en cliquant à l'extérieur -->
    <div id="mega-menu-overlay" class="hidden fixed inset-0 bg-black bg-opacity-30 z-40" onclick="toggleMegaMenu()">
    </div>

    <!-- Breaking News Ticker -->
    @if ($breakingNews ?? false)
        <div class="bg-gray-900 text-white overflow-hidden h-11">
            <div class="flex items-center h-full">
                <div
                    class="bg-red-600 px-6 h-full flex items-center font-bold text-xs uppercase tracking-wider animate-pulse">
                    FLASH INFO
                </div>
                <div class="flex items-center animate-scroll">
                    <marquee direction="left">
                        @foreach ($breakingNews as $news)
                            <span class="px-12 text-sm whitespace-nowrap">
                                <span class="text-blue-400">●</span> {{ $news->title }}
                            </span>
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- POPUP FLASH: DON -->
    <div id="donation-popup"
        class="flash-popup hidden bottom-6 right-6 w-96 max-w-[90vw] bg-gradient-to-br from-green-600 to-green-800 text-white rounded-2xl shadow-2xl">
        <div class="p-6">
            <!-- Bouton de fermeture -->
            <button onclick="closeFlashPopup('donation')"
                class="absolute top-3 right-3 text-white/70 hover:text-white text-2xl leading-none transition">
                ×
            </button>

            <div class="flex items-center gap-3 mb-4">
                <span class="text-4xl">💝</span>
                <h3 class="text-2xl font-bold">Soutenez-nous !</h3>
            </div>

            <p class="text-sm text-green-100 mb-4">
                Votre don nous aide à maintenir une information de qualité et indépendante.
            </p>

            <form action="{{ route('donation.process') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <input type="number" name="amount" placeholder="Montant (FCFA)" min="500" required
                        class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-300">
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="this.form.amount.value='1000'"
                        class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded text-sm font-semibold transition">
                        1 000
                    </button>
                    <button type="button" onclick="this.form.amount.value='5000'"
                        class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded text-sm font-semibold transition">
                        5 000
                    </button>
                    <button type="button" onclick="this.form.amount.value='10000'"
                        class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded text-sm font-semibold transition">
                        10 000
                    </button>
                </div>

                <button type="submit"
                    class="w-full bg-white text-green-600 px-4 py-3 rounded-lg font-bold hover:bg-green-50 transition shadow-lg">
                    Faire un don maintenant 💚
                </button>
            </form>

            <p class="text-xs text-center text-green-200 mt-3">
                🔒 Paiement 100% sécurisé
            </p>
        </div>
    </div>

    <!-- POPUP FLASH: PUBLICITÉ -->
    <div id="ad-popup"
        class="flash-popup hidden top-20 right-6 w-80 max-w-[90vw] bg-white rounded-2xl shadow-2xl overflow-hidden  mt-3">
        <!-- Bouton de fermeture -->
        <button onclick="closeFlashPopup('ad')"
            class="absolute top-3 right-3 z-10 bg-white/80 hover:bg-white text-gray-800 rounded-full w-8 h-8 flex items-center justify-center text-xl leading-none transition shadow-md">
            ×
        </button>

        <div class="bg-gradient-to-br from-purple-100 to-pink-100 p-8 text-center">
            <div class="text-6xl mb-4">🎯</div>
            <h4 class="font-bold text-xl text-gray-800 mb-2">
                Votre Pub Ici
            </h4>
            <p class="text-sm text-gray-600 mb-4">
                Touchez des milliers de lecteurs chaque jour !
            </p>
            <a href="{{ route('annonceurs') }}"
                class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full font-bold text-sm hover:shadow-lg hover:scale-105 transition">
                En savoir plus →
            </a>
        </div>

        <div class="bg-gray-50 px-4 py-2 text-center">
            <span class="text-xs text-gray-400 uppercase">Espace Publicitaire</span>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-blue-500 font-bold mb-4 uppercase">À Propos</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Qui sommes-nous ?</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">La rédaction</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-blue-500 font-bold mb-4 uppercase">Nos Services</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('direct') }}" class="hover:text-blue-400 transition">LCM+ en direct</a>
                        </li>
                        <li><a href="{{ route('replay') }}" class="hover:text-blue-400 transition">Replays</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Newsletters</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-blue-500 font-bold mb-4 uppercase">Rubriques</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach (\App\Models\Rubrique::active()->ordered()->take(6)->get() as $rubrique)
                            <li><a href="{{ route('rubrique.show', $rubrique->slug) }}"
                                    class="hover:text-blue-400 transition">{{ $rubrique->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-blue-500 font-bold mb-4 uppercase">Informations</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">CGU</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Confidentialité</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} LIGNE CLAIRE MÉDIA+ - Tous droits réservés</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            alert('Menu mobile à implémenter');
        }

        // ==========================================
        // SYSTÈME DE POPUPS FLASH
        // ==========================================

        const FLASH_POPUPS_CONFIG = {
            donation: {
                id: 'donation-popup',
                showAfter: 5000, // Apparaît après 5 secondes
                reappearAfter: 300000, // Réapparaît après 5 minutes (300000ms)
                storageKey: 'donation_popup_closed'
            },
            ad: {
                id: 'ad-popup',
                showAfter: 10000, // Apparaît après 10 secondes
                reappearAfter: 600000, // Réapparaît après 10 minutes (600000ms)
                storageKey: 'ad_popup_closed'
            }
        };

        // Fonction pour afficher un popup
        function showFlashPopup(type) {
            const config = FLASH_POPUPS_CONFIG[type];
            if (!config) return;

            const popup = document.getElementById(config.id);
            if (!popup) return;

            // Vérifier si le popup a été fermé récemment
            const closedTime = localStorage.getItem(config.storageKey);
            if (closedTime) {
                const timeSinceClosed = Date.now() - parseInt(closedTime);
                if (timeSinceClosed < config.reappearAfter) {
                    // Pas encore temps de réafficher
                    return;
                }
            }

            // Afficher le popup avec animation
            setTimeout(() => {
                popup.classList.remove('hidden');
                setTimeout(() => {
                    popup.classList.add('show');
                }, 10);
            }, config.showAfter);
        }

        // Fonction pour fermer un popup
        function closeFlashPopup(type) {
            const config = FLASH_POPUPS_CONFIG[type];
            if (!config) return;

            const popup = document.getElementById(config.id);
            if (!popup) return;

            // Animation de fermeture
            popup.classList.remove('show');
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 500);

            // Enregistrer l'heure de fermeture
            localStorage.setItem(config.storageKey, Date.now().toString());
        }

        // Initialiser les popups au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Afficher le popup de don
            showFlashPopup('donation');

            // Afficher le popup de pub
            showFlashPopup('ad');

            // Vérifier périodiquement si les popups doivent réapparaître
            setInterval(() => {
                Object.keys(FLASH_POPUPS_CONFIG).forEach(type => {
                    const config = FLASH_POPUPS_CONFIG[type];
                    const popup = document.getElementById(config.id);

                    // Si le popup est caché, vérifier s'il doit réapparaître
                    if (popup && popup.classList.contains('hidden')) {
                        const closedTime = localStorage.getItem(config.storageKey);
                        if (closedTime) {
                            const timeSinceClosed = Date.now() - parseInt(closedTime);
                            if (timeSinceClosed >= config.reappearAfter) {
                                // Réinitialiser et réafficher
                                localStorage.removeItem(config.storageKey);
                                showFlashPopup(type);
                            }
                        }
                    }
                });
            }, 30000); // Vérifier toutes les 30 secondes
        });
    </script>

    <script>
        let megaMenuOpen = false;

        function toggleMegaMenu() {
            const megaMenu = document.getElementById('mega-menu');
            const overlay = document.getElementById('mega-menu-overlay');
            const toggleIcon = document.getElementById('toggle-icon');
            const toggleBtn = document.getElementById('toggle-rubriques-btn');

            megaMenuOpen = !megaMenuOpen;

            if (megaMenuOpen) {
                // Ouvrir le mega menu
                megaMenu.classList.remove('hidden');
                overlay.classList.remove('hidden');
                toggleIcon.style.transform = 'rotate(180deg)';
                toggleBtn.classList.add('text-blue-800', 'bg-gray-50');

                // Animation d'entrée
                setTimeout(() => {
                    megaMenu.style.animation = 'slideDown 0.3s ease-out';
                }, 10);
            } else {
                // Fermer le mega menu
                megaMenu.style.animation = 'slideUp 0.3s ease-out';
                toggleIcon.style.transform = 'rotate(0deg)';
                toggleBtn.classList.remove('text-blue-800', 'bg-gray-50');

                setTimeout(() => {
                    megaMenu.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Fermer avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && megaMenuOpen) {
                toggleMegaMenu();
            }
        });

        // Animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }

            /* Mega menu responsive */
            @media (max-width: 768px) {
                #mega-menu .grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 0.5rem;
                }

                #mega-menu a {
                    padding: 0.75rem;
                    font-size: 0.75rem;
                }
            }

            @media (max-width: 640px) {
                #mega-menu .grid {
                    grid-template-columns: 1fr;
                }
            }

            /* Responsive pour mobile */
            @media (max-width: 1023px) {
                nav .container > div {
                    justify-content: flex-start !important;
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                #nav-container {
                    overflow-x: auto;
                }

                /* Barre de défilement personnalisée */
                #nav-container::-webkit-scrollbar {
                    height: 4px;
                }

                #nav-container::-webkit-scrollbar-track {
                    background: transparent;
                }

                #nav-container::-webkit-scrollbar-thumb {
                    background-color: #2563eb;
                    border-radius: 10px;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    @stack('scripts')
    <script>
        // Fonction pour ouvrir le menu latéral
        function openSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
            overlay.classList.add('show');

            // Empêcher le scroll du body
            document.body.style.overflow = 'hidden';
        }

        // Fonction pour fermer le menu latéral
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.remove('open');
            overlay.classList.remove('show');

            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);

            // Réactiver le scroll du body
            document.body.style.overflow = '';
        }

        // MODIFIEZ LA FONCTION toggleMobileMenu() EXISTANTE
        function toggleMobileMenu() {
            openSidebar();
        }

        // Fermer avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
