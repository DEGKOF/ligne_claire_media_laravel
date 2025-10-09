<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Backoffice') - LIGNE CLAIRE MÉDIA+</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <style>
        .cke_notification_message, .cke_notification{
            display: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex-shrink-0 hidden lg:block">
            <div class="p-6">
                <a href="{{ route('home') }}" target="_blank" class="text-xl font-black tracking-wide block mb-8">
                    LCM+ ADMIN
                </a>

                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                        <span>📊</span>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Publications -->
                    @if(auth()->user()->canWriteArticles())
                    <div class="mt-6">
                        <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Publications</div>
                        <a href="{{ route('admin.publications.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.publications.*') ? 'bg-white/20' : '' }}">
                            <span>📝</span>
                            <span class="font-medium">Tous les articles</span>
                        </a>
                        <a href="{{ route('admin.publications.create') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                            <span>➕</span>
                            <span class="font-medium">Nouveau</span>
                        </a>
                    </div>
                    @endif

                    <!-- Rubriques -->
                    @if(auth()->user()->canManageRubriques())
                    <div class="mt-6">
                        <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Rubriques</div>
                        <a href="{{ route('admin.rubriques.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.rubriques.*') ? 'bg-white/20' : '' }}">
                            <span>📂</span>
                            <span class="font-medium">Gérer les rubriques</span>
                        </a>
                    </div>
                    @endif

                    <!-- Utilisateurs (si admin) -->
                    @if(auth()->user()->isAdmin())
                    <div class="mt-6">
                        <div class="px-4 text-xs uppercase text-blue-300 font-bold mb-2">Système</div>
                        <a href="#"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                            <span>👥</span>
                            <span class="font-medium">Utilisateurs</span>
                        </a>
                        {{-- <a href="#"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                            <span>⚙️</span>
                            <span class="font-medium">Paramètres</span>
                        </a> --}}
                    </div>
                    @endif
                </nav>
            </div>

            <!-- User Info -->
            <div class="absolute bottom-0 w-64 p-4 bg-blue-950/50 border-t border-blue-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->username, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ auth()->user()->display_name ?? auth()->user()->username }}</div>
                        <div class="text-xs text-blue-300">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600">
                        ☰
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 hover:bg-gray-100 rounded-full">
                        <span class="text-xl">🔔</span>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Voir le site -->
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Voir le site →
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            // Implémenter toggle sidebar mobile
            alert('Sidebar mobile à implémenter');
        }
    </script>
{{-- <div id="editor">
    <p>This is the editor content.</p>
</div> --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );
</script>

    @stack('scripts')
</body>
</html>
