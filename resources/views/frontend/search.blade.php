@extends('layouts.frontend')

@section('title', 'Recherche : ' . $query . ' - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-black mb-4">🔍 Résultats de recherche</h1>
        <p class="text-xl text-gray-600">
            Vous avez recherché : <strong class="text-gray-900">"{{ $query }}"</strong>
        </p>
        <p class="text-gray-500 mt-2">
            {{ $results->total() }} résultat(s) trouvé(s)
        </p>
    </div>

    <!-- Search Form -->
    <form action="{{ route('search') }}" method="GET" class="mb-12">
        <div class="flex gap-3">
            <input type="text"
                   name="q"
                   value="{{ $query }}"
                   placeholder="Rechercher une actualité..."
                   class="flex-1 px-6 py-4 border-2 border-gray-300 rounded-lg text-lg focus:outline-none focus:border-blue-600 transition">
            <button type="submit"
                    class="bg-blue-600 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-700 transition">
                Rechercher
            </button>
        </div>
    </form>

    @if($results->isEmpty())
        <!-- No Results -->
        <div class="text-center py-16">
            <div class="text-6xl mb-4">😕</div>
            <h2 class="text-2xl font-bold mb-4">Aucun résultat trouvé</h2>
            <p class="text-gray-600 mb-8">
                Essayez avec d'autres mots-clés ou parcourez nos rubriques
            </p>
            <div class="flex gap-3 justify-center flex-wrap">
                @foreach(\App\Models\Rubrique::active()->ordered()->take(6)->get() as $rubrique)
                    <a href="{{ route('rubrique.show', $rubrique->slug) }}"
                       class="bg-white border-2 border-gray-300 px-6 py-3 rounded-full font-bold hover:border-blue-600 hover:text-blue-600 transition">
                        {{ $rubrique->icon }} {{ $rubrique->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <!-- Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($results as $publication)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition cursor-pointer">
                <a href="{{ route('publication.show', $publication->slug) }}">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                        @if($publication->featured_image)
                            <img src="{{ asset('storage/' . $publication->featured_image) }}"
                                 alt="{{ $publication->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            @if($publication->type === 'video_courte' || $publication->type === 'direct' || $publication->type === 'rediffusion')
                                <span class="text-white text-5xl">📹</span>
                            @else
                                <span class="text-white text-5xl">📰</span>
                            @endif
                        @endif
                        @if($publication->is_new)
                        <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                            NEW
                        </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-blue-600 text-xs font-bold uppercase">
                                {{ $publication->rubrique->name }}
                            </span>
                            @if($publication->type !== 'article')
                                <span class="text-red-600 text-xs font-bold uppercase">
                                    • {{ ucfirst(str_replace('_', ' ', $publication->type)) }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-3 leading-tight line-clamp-2 hover:text-blue-600 transition">
                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200">$1</mark>', $publication->title) !!}
                        </h3>
                        @if($publication->excerpt)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200">$1</mark>', $publication->excerpt) !!}
                        </p>
                        @endif
                        <div class="flex justify-between items-center text-xs text-gray-500 pt-4 border-t">
                            <span>⏱️ {{ $publication->published_at->diffForHumans() }}</span>
                            <span>👁️ {{ number_format($publication->views_count) }} vues</span>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $results->appends(['q' => $query])->links() }}
        </div>
    @endif
</div>
@endsection
