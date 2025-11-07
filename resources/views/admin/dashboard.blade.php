@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Publications -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Total Publications</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_publications']) }}</p>
            </div>
            <div class="text-blue-600 text-4xl">
                {{-- <i class="fas fa-file-alt"></i> --}}
            </div>
        </div>
    </div>

    <!-- Publiées -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Publiées</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['published_publications']) }}</p>
            </div>
            <div class="text-green-600 text-4xl">
                {{-- <i class="fas fa-check-circle"></i> --}}
            </div>
        </div>
    </div>

    <!-- Brouillons -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-yellow-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Brouillons</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['draft_publications']) }}</p>
            </div>
            <div class="text-yellow-600 text-4xl">
                {{-- <i class="fas fa-edit"></i> --}}
            </div>
        </div>
    </div>

    <!-- Vues Totales -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Vues Totales</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="text-purple-600 text-4xl">
                {{-- <i class="fas fa-eye"></i> --}}
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Publications récentes -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            {{-- <i class="fas fa-newspaper"></i> --}}
            Publications récentes
        </h2>
        <div class="space-y-3">
            @foreach($recentPublications as $publication)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.publications.edit', $publication) }}"
                       class="font-semibold text-gray-900 hover:text-blue-600 block truncate">
                        {{ $publication->title }}
                    </a>
                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                        <span>{{ $publication->rubrique->name }}</span>
                        <span>•</span>
                        <span>{{ $publication->user->public_name }}</span>
                        <span>•</span>
                        <span>{{ $publication->published_at?->diffForHumans() ?? 'Brouillon' }}</span>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $publication->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($publication->status) }}
                </span>
            </div>
            @endforeach
        </div>
        <a href="{{ route('admin.publications.index') }}"
           class="block text-center mt-4 text-blue-600 hover:text-blue-800 font-semibold text-sm">
            Voir toutes les publications
            {{-- <i class="fas fa-arrow-right ml-1"></i> --}}
        </a>
    </div>

    <!-- Rubriques populaires -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            {{-- <i class="fas fa-fire"></i> --}}
            Rubriques les plus vues
        </h2>
        <div class="space-y-3">
            @foreach($popularRubriques as $rubrique)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $rubrique->icon }}</span>
                    <div>
                        <a href="{{ route('admin.rubriques.edit', $rubrique) }}"
                           class="font-semibold text-gray-900 hover:text-blue-600">
                            {{ $rubrique->name }}
                        </a>
                        <div class="text-xs text-gray-500">
                            {{ $rubrique->publications_count ?? 0 }} publications
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-lg text-gray-900">
                        {{ number_format($rubrique->views_count) }}
                    </div>
                    <div class="text-xs text-gray-500">vues</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Articles les plus vus -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            {{-- <i class="fas fa-chart-line"></i> --}}
            Articles les plus vus
        </h2>
        <div class="space-y-3">
            @foreach($popularArticles as $index => $article)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="text-2xl font-bold text-blue-600 min-w-[32px]">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.publications.edit', $article) }}"
                       class="font-semibold text-gray-900 hover:text-blue-600 block truncate">
                        {{ $article->title }}
                    </a>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ number_format($article->views_count) }} vues
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Auteurs les plus actifs -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            {{-- <i class="fas fa-pen-fancy"></i> --}}
            Auteurs les plus actifs
        </h2>
        <div class="space-y-3">
            @foreach($topAuthors as $author)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr($author->prenom, 0, 1) }}{{ substr($author->nom, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">
                            {{ $author->full_name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ ucfirst($author->role) }}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-lg text-gray-900">
                        {{ $author->publications_count }}
                    </div>
                    <div class="text-xs text-gray-500">articles</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Types de publications -->
@if($publicationsByType->isNotEmpty())
<div class="bg-white rounded-lg shadow-lg p-6 mt-8">
    <h2 class="text-xl font-bold mb-4">Répartition par type</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach($publicationsByType as $type => $count)
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-3xl mb-2">
                @switch($type)
                    @case('article')
                        {{-- <i class="fas fa-newspaper text-blue-600"></i> --}}
                        @break
                    @case('direct')
                        {{-- <i class="fas fa-circle text-red-600"></i> --}}
                        @break
                    @case('rediffusion')
                        {{-- <i class="fas fa-tv text-purple-600"></i> --}}
                        @break
                    @case('video_courte')
                        {{-- <i class="fas fa-video text-green-600"></i> --}}
                        @break
                    @case('lien_externe')
                        {{-- <i class="fas fa-external-link-alt text-orange-600"></i> --}}
                        @break
                @endswitch
            </div>
            <div class="font-bold text-2xl text-gray-900">{{ $count }}</div>
            <div class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $type) }}</div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
