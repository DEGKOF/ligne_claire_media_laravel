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

                        @if(auth()->user()->isAdmin())
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

                        @if(auth()->user()->isAdmin())
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
                                <span class="font-medium">Mon Profil</span>
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

            <!-- User Info Desktop -->
            <div class="p-4 bg-blue-950/50 border-t border-blue-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ auth()->user()->display_name ?? auth()->user()->username }}</div>
                        <div class="text-xs text-blue-300">{{ ucfirst(auth()->user()->role) }}</div>
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

                        @if(auth()->user()->isAdmin())
                            <div class="mt-6">
                                <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Utilisateurs externes</div>
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
                        {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ auth()->user()->display_name ?? auth()->user()->username }}</div>
                        <div class="text-xs text-blue-300">{{ ucfirst(auth()->user()->role) }}</div>
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

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        if (document.getElementById('editor')) {
            CKEDITOR.replace('editor');
        }
    </script>

    @stack('scripts')
</body>
</html>
