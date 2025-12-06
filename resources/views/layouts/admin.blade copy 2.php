<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>@yield('title', 'Backoffice') - LIGNE CLAIRE MÉDIA+</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <style>
        .cke_notification_message, .cke_notification {
            display: none !important;
        }

        /* Sidebar mobile */
        #mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        #mobile-sidebar.open {
            transform: translateX(0);
        }

        #sidebar-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        #sidebar-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* Scrollbar personnalisée */
        aside::-webkit-scrollbar {
            width: 6px;
        }

        aside::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        aside::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        aside::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Animation pour le contenu */
        @media (max-width: 1023px) {
            .content-wrapper {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        <!-- Overlay mobile -->
        <div id="sidebar-overlay"
             onclick="closeSidebar()"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
        </div>

        <!-- Sidebar Desktop -->
        <aside class="hidden lg:flex lg:flex-col w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex-shrink-0">
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-black tracking-wide block mb-8 hover:text-blue-200 transition">
                            LCM+ ADMIN
                        </a>
                    @endif

                    @if(auth()->user()->isAdvertiser())
                        <a href="{{ route('advertiser.dashboard') }}" class="text-xl font-black tracking-wide block mb-8 hover:text-blue-200 transition">
                            LCM+ Pubs
                        </a>
                    @endif

                    <nav class="space-y-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-chart-line w-5"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        @endif

                        @if(auth()->user()->canWriteArticles())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Publications</div>
                                <a href="{{ route('admin.publications.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.publications.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-newspaper w-5"></i>
                                    <span class="font-medium">Tous les articles</span>
                                </a>
                                <a href="{{ route('admin.publications.create') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-plus-circle w-5"></i>
                                    <span class="font-medium">Nouveau</span>
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->canManageRubriques() || auth()->user()->canWriteArticles())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Rubriques</div>
                                <a href="{{ route('admin.rubriques.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.rubriques.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-folder w-5"></i>
                                    <span class="font-medium">Rubriques</span>
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->isMasterAdmin())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Pôles</div>
                                <a href="{{ route('admin.community.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.community.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-users w-5"></i>
                                    <span class="font-medium">Communautés</span>
                                </a>
                                <a href="{{ route('admin.investigations.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.investigations.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-search w-5"></i>
                                    <span class="font-medium">Investigations</span>
                                </a>
                                <a href="{{ route('admin.testimonies.index.page') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.testimonies.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-comment-dots w-5"></i>
                                    <span class="font-medium">Témoignages</span>
                                </a>
                            </div>

                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Publicités</div>
                                <a href="{{ route('admin.advertisers.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.advertisers.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-bullhorn w-5"></i>
                                    <span class="font-medium">Annonceurs</span>
                                </a>
                                <a href="{{ route('admin.advertisements.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.advertisements.*') && !request()->routeIs('admin.advertisements.placements.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-ad w-5"></i>
                                    <span class="font-medium">Campagnes</span>
                                </a>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('admin.candidatures.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.candidatures.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-briefcase w-5"></i>
                                    <span class="font-medium">Candidatures</span>
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->isAdvertiser())
                            <a href="{{ route('advertiser.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-chart-line w-5"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('advertiser.profile.complete') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.profile.complete') ? 'bg-white/20' : '' }}">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                <span class="font-medium">Entrprise</span>
                            </a>

                            <a href="{{ route('advertiser.campaigns.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.campaigns.index') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-bullhorn w-5"></i>
                                <span class="font-medium">Campagnes</span>
                            </a>
                        @endif

                        @if(auth()->user()->isMasterAdmin())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Système</div>
                                <a href="{{ route('admin.users.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-users-cog w-5"></i>
                                    <span class="font-medium">Utilisateurs</span>
                                </a>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('profile.*') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-user-edit w-5"></i>
                                <span class="font-medium">Compte </span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- User Info Desktop -->
            <div class="p-4 bg-blue-950/50 border-t border-blue-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->nom, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ auth()->user()->prenom ?? auth()->user()->username }}</div>
                        <div class="text-xs text-blue-300">{{ str_replace('_', ' ', ucfirst(auth()->user()->role)) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar Mobile -->
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white lg:hidden flex flex-col">
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-8">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-xl font-black tracking-wide hover:text-blue-200 transition">
                                LCM+ ADMIN
                            </a>
                        @endif

                        @if(auth()->user()->isAdvertiser())
                            <a href="{{ route('advertiser.dashboard') }}" class="text-xl font-black tracking-wide hover:text-blue-200 transition">
                                LCM+ Pubs
                            </a>
                        @endif

                        <button onclick="closeSidebar()" class="text-white hover:text-blue-200">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <nav class="space-y-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-chart-line w-5"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        @endif

                        @if(auth()->user()->canWriteArticles())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Publications</div>
                                <a href="{{ route('admin.publications.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.publications.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-newspaper w-5"></i>
                                    <span class="font-medium">Tous les articles</span>
                                </a>
                                <a href="{{ route('admin.publications.create') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-plus-circle w-5"></i>
                                    <span class="font-medium">Nouveau</span>
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->canManageRubriques())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Rubriques</div>
                                <a href="{{ route('admin.rubriques.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.rubriques.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-folder w-5"></i>
                                    <span class="font-medium">Rubriques</span>
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->isMasterAdmin())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Pôles</div>
                                <a href="{{ route('admin.community.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.community.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-users w-5"></i>
                                    <span class="font-medium">Communautés</span>
                                </a>
                                <a href="{{ route('admin.investigations.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.investigations.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-search w-5"></i>
                                    <span class="font-medium">Investigations</span>
                                </a>
                                <a href="{{ route('admin.testimonies.index.page') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.testimonies.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-comment-dots w-5"></i>
                                    <span class="font-medium">Témoignages</span>
                                </a>
                            </div>

                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Publicités</div>
                                <a href="{{ route('admin.advertisers.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.advertisers.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-bullhorn w-5"></i>
                                    <span class="font-medium">Annonceurs</span>
                                </a>
                                <a href="{{ route('admin.advertisements.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.advertisements.*') && !request()->routeIs('admin.advertisements.placements.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-ad w-5"></i>
                                    <span class="font-medium">Campagnes</span>
                                </a>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('admin.candidatures.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.candidatures.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-briefcase w-5"></i>
                                    <span class="font-medium">Candidatures</span>
                                </a>
                            </div>
                        @endif


                        @if(auth()->user()->isMasterAdmin())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Système</div>
                                <a href="{{ route('admin.users.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-users-cog w-5"></i>
                                    <span class="font-medium">Utilisateurs</span>
                                </a>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('profile.*') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-user-edit w-5"></i>
                                <span class="font-medium">Compte </span>
                            </a>
                        </div>

                        @if(auth()->user()->isAdvertiser())
                            <a href="{{ route('advertiser.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-chart-line w-5"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('advertiser.profile.complete') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.profile.complete') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-user w-5"></i>
                                <span class="font-medium">Mon profile</span>
                            </a>

                            <a href="{{ route('advertiser.campaigns.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('advertiser.campaigns.index') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-bullhorn w-5"></i>
                                <span class="font-medium">Mes campagnes</span>
                            </a>
                        @endif
                    </nav>
                </div>
            </div>

            <!-- User Info Mobile -->
            <div class="p-4 bg-blue-950/50 border-t border-blue-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->nom, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ auth()->user()->prenom ?? auth()->user()->username }}</div>
                        <div class="text-xs text-blue-300">{{ str_replace('_', ' ', ucfirst(auth()->user()->role)) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden content-wrapper">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 sm:px-6 flex-shrink-0">
                <div class="flex items-center gap-4 min-w-0 flex-1">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-gray-900 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-800 truncate">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Voir le site -->
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="hidden sm:inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Voir le site</span>
                    </a>

                    <!-- Version mobile du lien -->
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="sm:hidden text-blue-600 hover:text-blue-800 transition"
                       title="Voir le site">
                        <i class="fas fa-external-link-alt text-lg"></i>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg font-medium text-sm transition shadow-sm hover:shadow-md">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-start gap-3">
                        <i class="fas fa-check-circle text-xl mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-xl mt-0.5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    </script>

    {{-- <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        if (document.getElementById('editor')) {
            CKEDITOR.replace('editor');
        }
    </script> --}}

    {{-- <script>
        // ========================================
        // 1. DÉSACTIVER LE CLIC DROIT
        // ========================================
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // ========================================
        // 2. BLOQUER LES RACCOURCIS CLAVIER
        // ========================================
        document.addEventListener('keydown', function(e) {
            // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+S
            if (
                e.keyCode === 123 || // F12
                (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
                (e.ctrlKey && e.shiftKey && e.keyCode === 74) || // Ctrl+Shift+J
                (e.ctrlKey && e.keyCode === 85) || // Ctrl+U
                (e.ctrlKey && e.keyCode === 83) || // Ctrl+S
                (e.ctrlKey && e.shiftKey && e.keyCode === 67) || // Ctrl+Shift+C
                (e.metaKey && e.altKey && e.keyCode === 73) || // Cmd+Option+I (Mac)
                (e.metaKey && e.altKey && e.keyCode === 74)    // Cmd+Option+J (Mac)
            ) {
                e.preventDefault();
                return false;
            }
        });

        // ========================================
        // 3. DÉSACTIVER LA SÉLECTION DE TEXTE
        // ========================================
        document.onselectstart = function() { return false; };
        document.ondragstart = function() { return false; };

        // Via CSS aussi
        document.body.style.userSelect = 'none';
        document.body.style.webkitUserSelect = 'none';
        document.body.style.mozUserSelect = 'none';
        document.body.style.msUserSelect = 'none';

        // ========================================
        // 4. DÉTECTION DES DEVTOOLS (Améliorée)
        // ========================================
        (function() {
            let devtoolsOpen = false;

            const detectDevTools = () => {
                // Ne pas bloquer sur mobile ou petits écrans
                if (window.innerWidth < 768) return;

                const threshold = 160;
                const widthThreshold = window.outerWidth - window.innerWidth > threshold;
                const heightThreshold = window.outerHeight - window.innerHeight > threshold;

                // Vérifier aussi si la console est ouverte
                const element = new Image();
                Object.defineProperty(element, 'id', {
                    get: function() {
                        devtoolsOpen = true;
                        throw new Error('DevTools');
                    }
                });

                if ((widthThreshold || heightThreshold) && devtoolsOpen) {
                    // DevTools vraiment détectés
                    document.body.innerHTML = '<h1 style="text-align:center; margin-top:50px;">⛔ Accès non autorisé détecté</h1>';
                    setTimeout(() => window.location.reload(), 500);
                }

                devtoolsOpen = false;
            };

            // Vérifier toutes les 2 secondes (moins agressif)
            setInterval(detectDevTools, 2000);

            // Détecter via debugger (seulement sur desktop)
            if (window.innerWidth >= 768) {
                setInterval(function() {
                    const start = performance.now();
                    debugger;
                    const end = performance.now();
                    if (end - start > 100) {
                        document.body.innerHTML = '<h1 style="text-align:center; margin-top:50px;">⛔ Débogage détecté</h1>';
                        setTimeout(() => window.location.reload(), 500);
                    }
                }, 2000);
            }
        })();

        // ========================================
        // 5. PROTECTION CONTRE LE COPIER-COLLER
        // ========================================
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            return false;
        });

        // ========================================
        // 6. DÉSACTIVER L'IMPRESSION
        // ========================================
        window.addEventListener('beforeprint', function(e) {
            e.preventDefault();
            document.body.innerHTML = '<h1>Impression désactivée</h1>';
        });

        // ========================================
        // 7. DÉTECTION BASIQUE DE BOTS
        // ========================================
        (function() {
            const botPatterns = [
                /bot/i, /crawl/i, /spider/i, /wget/i, /curl/i,
                /httrack/i, /scraper/i, /python/i
            ];

            const userAgent = navigator.userAgent.toLowerCase();
            const isBot = botPatterns.some(pattern => pattern.test(userAgent));

            if (isBot) {
                document.body.innerHTML = '<h1>Accès refusé</h1>';
                throw new Error('Bot détecté');
            }

            // Vérifier si webdriver est activé (Selenium, Puppeteer)
            if (navigator.webdriver) {
                document.body.innerHTML = '<h1>Accès automatisé détecté</h1>';
                throw new Error('WebDriver détecté');
            }
        })();

        // ========================================
        // 8. OBSCURCIR LE CODE SOURCE
        // ========================================
        console.log = console.warn = console.error = function() {};
        console.clear();

        // ========================================
        // 9. PROTECTION CONTRE LES IFRAMES
        // ========================================
        if (window.top !== window.self) {
            window.top.location = window.self.location;
        }
    </script> --}}

    // CKEditor 5 avec Upload d'Images ET de Vidéos (Solution simplifiée)
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/fr.js"></script>

<script>
class UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
    }

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.publications.upload-image") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Impossible de télécharger le fichier: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (!response || response.error) {
                return reject(response && response.error ? response.error.message : genericErrorText);
            }

            resolve({
                default: response.url
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);
        this.xhr.send(data);
    }
}

function CustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new UploadAdapter(loader);
    };
}

let editorInstance;

ClassicEditor
    .create(document.querySelector('#editor'), {
        language: 'fr',
        extraPlugins: [CustomUploadAdapterPlugin],
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'uploadImage', 'mediaEmbed', 'insertTable', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'blockQuote', 'code', 'codeBlock', '|',
                'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', '|',
                'horizontalLine', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Titre 4', class: 'ck-heading_heading4' }
            ]
        },
        image: {
            toolbar: [
                'imageTextAlternative', 'toggleImageCaption', '|',
                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                'linkImage'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableCellProperties', 'tableProperties'
            ]
        },
        mediaEmbed: {
            previewsInData: true,
            providers: [
                {
                    name: 'youtube',
                    url: [
                        /^(?:m\.)?youtube\.com\/watch\?v=([\w-]+)/,
                        /^(?:m\.)?youtube\.com\/v\/([\w-]+)/,
                        /^youtube\.com\/embed\/([\w-]+)/,
                        /^youtu\.be\/([\w-]+)/
                    ],
                    html: match => {
                        const id = match[1];
                        return (
                            '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">' +
                                `<iframe src="https://www.youtube.com/embed/${id}" ` +
                                'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ' +
                                'frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>' +
                                '</iframe>' +
                            '</div>'
                        );
                    }
                },
                {
                    name: 'vimeo',
                    url: /^vimeo\.com\/(\d+)/,
                    html: match => {
                        const id = match[1];
                        return (
                            '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">' +
                                `<iframe src="https://player.vimeo.com/video/${id}" ` +
                                'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ' +
                                'frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>' +
                                '</iframe>' +
                            '</div>'
                        );
                    }
                },
                {
                    name: 'dailymotion',
                    url: /^dailymotion\.com\/video\/([^_]+)/,
                    html: match => {
                        const id = match[1];
                        return (
                            '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">' +
                                `<iframe src="https://www.dailymotion.com/embed/video/${id}" ` +
                                'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ' +
                                'frameborder="0" allow="autoplay; fullscreen" allowfullscreen>' +
                                '</iframe>' +
                            '</div>'
                        );
                    }
                },
                {
                    name: 'direct_video',
                    url: /\.(mp4|webm|ogg|mov)$/i,
                    html: match => {
                        const url = match.input;
                        return (
                            '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">' +
                                '<video controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">' +
                                    `<source src="${url}" type="video/mp4">` +
                                    'Votre navigateur ne supporte pas la lecture de vidéos.' +
                                '</video>' +
                            '</div>'
                        );
                    }
                }
            ]
        },
        fontSize: {
            options: ['tiny', 'small', 'default', 'big', 'huge']
        }
    })
    .then(editor => {
        editorInstance = editor;
        console.log('✅ CKEditor initialisé avec succès');
        window.editor = editor;
    })
    .catch(error => {
        console.error('❌ Erreur lors de l\'initialisation de CKEditor:', error);
    });

// Bouton personnalisé pour l'upload de vidéos
document.addEventListener('DOMContentLoaded', function() {
    // Créer un bouton séparé pour uploader des vidéos
    const toolbar = document.querySelector('.ck-editor__top');

    if (toolbar) {
        setTimeout(() => {
            const videoBtn = document.createElement('button');
            videoBtn.type = 'button';
            videoBtn.className = 'ck ck-button ck-off';
            videoBtn.innerHTML = `
                <span class="ck-button__label">🎬 Vidéo</span>
            `;
            videoBtn.style.cssText = 'margin-left: 10px; padding: 8px 12px; background: #f0f0f0; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; font-size: 14px;';

            videoBtn.onclick = function() {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'video/*';

                input.onchange = async (e) => {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Vérifier la taille (max 50MB)
                    if (file.size > 50 * 1024 * 1024) {
                        alert('❌ La vidéo est trop volumineuse. Maximum 50 MB.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('upload', file);

                    // Afficher un loader
                    videoBtn.innerHTML = '<span class="ck-button__label">⏳ Upload...</span>';
                    videoBtn.disabled = true;

                    try {
                        const response = await fetch('{{ route("admin.publications.upload-video") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.url) {
                            // Insérer la vidéo dans l'éditeur
                            const videoHtml = `
                                <figure class="media">
                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                        <video controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                            <source src="${data.url}" type="${file.type}">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    </div>
                                </figure>
                            `;

                            const viewFragment = editorInstance.data.processor.toView(videoHtml);
                            const modelFragment = editorInstance.data.toModel(viewFragment);
                            editorInstance.model.insertContent(modelFragment);

                            alert('✅ Vidéo ajoutée avec succès !');
                        } else {
                            alert('❌ Erreur lors de l\'upload de la vidéo.');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        alert('❌ Erreur lors de l\'upload de la vidéo.');
                    } finally {
                        videoBtn.innerHTML = '<span class="ck-button__label">🎬 Vidéo</span>';
                        videoBtn.disabled = false;
                    }
                };

                input.click();
            };

            toolbar.appendChild(videoBtn);
        }, 500);
    }
});
</script>

<style>
    .ck-editor__editable {
        min-height: 500px;
        max-height: 800px;
    }

    .ck-content img {
        max-width: 100%;
        height: auto;
    }

    .ck-content video {
        max-width: 100%;
        height: auto;
    }

    .ck-content figure.media {
        margin: 1.5em 0;
    }

    .ck-content figure.media > div {
        position: relative;
        padding-bottom: 56.25%;
    }

    .ck-content blockquote {
        border-left: 4px solid #ccc;
        padding-left: 1em;
        margin-left: 0;
        font-style: italic;
        color: #666;
    }

    .ck-content pre {
        background: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1em;
        overflow-x: auto;
    }

    .ck-content code {
        background: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', Courier, monospace;
    }
</style>

    @stack('scripts')
</body>
</html>
