@extends('layouts.frontend')

@section('title', 'Recherche : ' . $query . ' - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h1 class="text-4xl font-black">Résultats de recherche</h1>
        </div>
        <p class="text-xl text-gray-600">
            Vous avez recherché : <strong class="text-gray-900">"{{ $query }}"</strong>
        </p>
        <p class="text-gray-500 mt-2">
            {{ $results->total() }} résultat(s) trouvé(s)
        </p>
    </div>

    <!-- Search Form -->
    <form action="{{ route('search') }}" method="GET" class="mb-8">
        <div class="flex gap-3">
            <div class="relative flex-1">
                <input type="text"
                       name="q"
                       value="{{ $query }}"
                       placeholder="Rechercher une actualité..."
                       class="w-full px-6 py-4 pl-12 border-2 border-gray-300 rounded-lg text-lg focus:outline-none focus:border-blue-600 transition">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Rechercher
            </button>
        </div>
    </form>

    @if($results->isEmpty())
        <!-- No Results -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
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
                                <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            @endif
                        @endif
                        {{-- @if($publication->is_new) --}}
                        @if ($publication->published_at && $publication->published_at->gt(now()->subHours(12)))
                            <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
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
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $publication->published_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($publication->views_count) }} vues
                            </span>
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
