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

    @stack('styles')
</head>
<body class="font-sans antialiased">

    <!-- Top Bar -->
    <div class="bg-black text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center text-xs">
            <div class="flex gap-4 items-center">
                <span class="bg-red-600 px-3 py-1 rounded animate-pulse font-bold">● EN DIRECT</span>
                <span>{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY • HH:mm') }}</span>
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-blue-400 transition">Facebook</a>
                <a href="#" class="hover:text-blue-400 transition">Twitter</a>
                <a href="#" class="hover:text-blue-400 transition">Instagram</a>
                <a href="#" class="hover:text-blue-400 transition">YouTube</a>
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
                    <a href="{{ route('direct') }}"
                       class="bg-red-600 border-2 border-red-600 text-white px-4 py-2 rounded-full text-xs uppercase font-bold hover:bg-red-700 transition">
                        ● Direct
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white border-b-3 border-blue-600 shadow">
        <div class="container mx-auto px-4">
            <div class="flex overflow-x-auto">
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
            <div class="bg-red-600 px-6 h-full flex items-center font-bold text-xs uppercase tracking-wider">
                FLASH INFO
            </div>
            <div class="flex items-center animate-scroll">
                @foreach($breakingNews as $news)
                    <span class="px-12 text-sm whitespace-nowrap">
                        • <span class="text-blue-400">●</span> {{ $news->title }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

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
            // Implémenter le menu mobile
            alert('Menu mobile à implémenter');
        }
    </script>

    @stack('scripts')
</body>
</html>
