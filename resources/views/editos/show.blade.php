@extends('layouts.frontend')

@section('title', $edito->title)

@section('content')
<article class="bg-gray-50 py-12 text-justify">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de l'article -->
        <header class="mb-8">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6">
                <ol class="flex items-center gap-2 text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-600 transition">Accueil</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('editos.index') }}" class="hover:text-blue-600 transition">Éditos</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ Str::limit($edito->title, 50) }}</li>
                </ol>
            </nav>

            <!-- Badge Édito -->
            <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-pen-fancy mr-2"></i>
                    Édito
                </span>
            </div>

            <!-- Titre -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $edito->title }}
            </h1>

            <!-- Métadonnées -->
            <div class="flex flex-wrap items-center gap-6 text-gray-600">
                <!-- Auteur -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($edito->user->nom ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Écrit par</div>
                        <div class="font-semibold text-gray-900">
                            {{ $edito->user->nom . " " . $edito->user->prenom ?? 'La Rédaction' }}
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-500">Publié le</div>
                        <div class="font-medium text-gray-900">
                            {{ $edito->published_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- Temps de lecture estimé -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-500">Lecture</div>
                        <div class="font-medium text-gray-900">
                            {{ ceil(str_word_count(strip_tags($edito->content)) / 200) }} min
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Image de couverture -->
        @if($edito->cover_image)
        <div class="mb-8 rounded-2xl overflow-hidden shadow-xl">
            <img src="{{ asset('storage/'. $edito->cover_image) }}"
                 alt="{{ $edito->title }}"
                 class="w-full h-auto">
        </div>
        @endif

        <!-- Contenu principal -->
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-12">
            <!-- Extrait si présent -->
            @if($edito->excerpt)
            <div class="text-xl text-gray-700 font-medium mb-8 pb-8 border-b border-gray-200 italic">
                {{ $edito->excerpt }}
            </div>
            @endif

            <!-- Contenu formaté par CKEditor -->
            <div class="prose prose-lg max-w-none">
                {!! $edito->content !!}
            </div>
        </div>

        <!-- Partage social -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Partager cet édito</h3>
            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('editos.show', $edito->slug)) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('editos.show', $edito->slug)) }}&text={{ urlencode($edito->title) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </a>
                <a href="https://wa.me/?text={{ urlencode($edito->title . ' - ' . route('editos.show', $edito->slug)) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
                <button onclick="copyLink()"
                        class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                    <i class="fas fa-link"></i>
                    <span>Copier le lien</span>
                </button>
            </div>
        </div>

        <!-- Éditos récents -->
        @if($recentEditos->count() > 0)
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Autres éditos récents</h3>
            <div class="space-y-4">
                @foreach($recentEditos as $recent)
                <a href="{{ route('editos.show', $recent->slug) }}"
                   class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition">
                    @if($recent->cover_image)
                        <img src="{{ asset('storage/'. $recent->cover_image) }}"
                             alt="{{ $recent->title }}"
                             class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-pen-fancy text-gray-400"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $recent->title }}</h4>
                        <div class="text-sm text-gray-600 flex items-center gap-3">
                            <span>{{ $recent->published_at->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span>{{ $recent->user->prenom ?? $recent->user->username }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Retour -->
        <div class="mt-12 text-center">
            <a href="{{ route('editos.index') }}"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition">
                <i class="fas fa-arrow-left"></i>
                Retour aux éditos
            </a>
        </div>
    </div>
</article>

<!-- Styles pour le contenu CKEditor -->
<style>
.prose {
    color: #374151;
}

.prose h2 {
    font-size: 1.875rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}

.prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #111827;
}

.prose p {
    margin-bottom: 1.25rem;
    line-height: 1.75;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 2rem 0;
}

.prose blockquote {
    border-left: 4px solid #3B82F6;
    padding-left: 1rem;
    font-style: italic;
    color: #6B7280;
    margin: 1.5rem 0;
}

.prose ul, .prose ol {
    margin: 1.25rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose a {
    color: #3B82F6;
    text-decoration: underline;
}

.prose a:hover {
    color: #2563EB;
}

.prose code {
    background-color: #F3F4F6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: monospace;
    font-size: 0.875em;
}

.prose pre {
    background-color: #1F2937;
    color: #F9FAFB;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.prose th, .prose td {
    border: 1px solid #E5E7EB;
    padding: 0.75rem;
    text-align: left;
}

.prose th {
    background-color: #F9FAFB;
    font-weight: 600;
}
</style>

<script>
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Lien copié dans le presse-papier !');
    });
}
</script>
@endsection
