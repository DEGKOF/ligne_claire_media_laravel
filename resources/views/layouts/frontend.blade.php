<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LIGNE CLAIRE MÉDIA+ - L\'info en continu')</title>

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
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased">

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
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-white text-2xl" onclick="toggleMobileMenu()">☰</button>
                    <a href="{{ route('home') }}" class="text-white text-2xl lg:text-4xl font-black tracking-wider">
                        LIGNE CLAIRE MÉDIA+
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('search') }}" method="GET" class="w-full">
                        <input type="text"
                               name="q"
                               placeholder="🔍 Rechercher une actualité..."
                               class="w-full px-4 py-2 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('replay') }}"
                       class="bg-transparent border-2 border-white/30 text-white px-4 py-2 rounded-full text-xs uppercase font-bold hover:bg-white/10 transition">
                        📺 Replay
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white border-b-3 border-blue-600 shadow">
        <div class="container mx-auto px-4">
            <div class="flex overflow-x-auto">
                    <a href="{{ route('home') }}"
                       class="px-4 py-3 text-sm font-semibold uppercase whitespace-nowrap hover:text-blue-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-blue-600 transition {{ request()->routeIs('home') ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-gray-800' }}">
                        {{ "accueil" }}
                    </a>
                @foreach(\App\Models\Rubrique::active()->ordered()->get() as $rubrique)
                    <a href="{{ route('rubrique.show', $rubrique->slug) }}"
                       class="px-4 py-3 text-sm font-semibold uppercase whitespace-nowrap hover:text-blue-600 hover:bg-gray-50 border-b-3 border-transparent hover:border-blue-600 transition {{ request()->routeIs('rubrique.show') && request()->route('slug') === $rubrique->slug ? 'text-blue-600 border-blue-600 bg-gray-50' : 'text-gray-800' }}">
                        {{ $rubrique->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Breaking News Ticker -->
    @if($breakingNews ?? false)
    <div class="bg-gray-900 text-white overflow-hidden h-11">
        <div class="flex items-center h-full">
            <div class="bg-red-600 px-6 h-full flex items-center font-bold text-xs uppercase tracking-wider animate-pulse">
                FLASH INFO
            </div>
            <div class="flex items-center animate-scroll">
                <marquee direction="left">
                    @foreach($breakingNews as $news)
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
    <div id="donation-popup" class="flash-popup hidden bottom-6 right-6 w-96 max-w-[90vw] bg-gradient-to-br from-green-600 to-green-800 text-white rounded-2xl shadow-2xl">
        <div class="p-6">
            <!-- Bouton de fermeture -->
            <button onclick="closeFlashPopup('donation')" class="absolute top-3 right-3 text-white/70 hover:text-white text-2xl leading-none transition">
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
                    <input type="number"
                           name="amount"
                           placeholder="Montant (FCFA)"
                           min="500"
                           required
                           class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-300">
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <button type="button"
                            onclick="this.form.amount.value='1000'"
                            class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded text-sm font-semibold transition">
                        1 000
                    </button>
                    <button type="button"
                            onclick="this.form.amount.value='5000'"
                            class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded text-sm font-semibold transition">
                        5 000
                    </button>
                    <button type="button"
                            onclick="this.form.amount.value='10000'"
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
    <div id="ad-popup" class="flash-popup hidden top-20 right-6 w-80 max-w-[90vw] bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Bouton de fermeture -->
        <button onclick="closeFlashPopup('ad')" class="absolute top-3 right-3 z-10 bg-white/80 hover:bg-white text-gray-800 rounded-full w-8 h-8 flex items-center justify-center text-xl leading-none transition shadow-md">
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
            <a href="{{ route('advertising.contact') }}"
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
                        <li><a href="{{ route('direct') }}" class="hover:text-blue-400 transition">LCM+ en direct</a></li>
                        <li><a href="{{ route('replay') }}" class="hover:text-blue-400 transition">Replays</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Newsletters</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-blue-500 font-bold mb-4 uppercase">Rubriques</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach(\App\Models\Rubrique::active()->ordered()->take(6)->get() as $rubrique)
                            <li><a href="{{ route('rubrique.show', $rubrique->slug) }}" class="hover:text-blue-400 transition">{{ $rubrique->name }}</a></li>
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
                showAfter: 5000,        // Apparaît après 5 secondes
                reappearAfter: 300000,  // Réapparaît après 5 minutes (300000ms)
                storageKey: 'donation_popup_closed'
            },
            ad: {
                id: 'ad-popup',
                showAfter: 10000,       // Apparaît après 10 secondes
                reappearAfter: 600000,  // Réapparaît après 10 minutes (600000ms)
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

    @stack('scripts')
</body>
</html>
