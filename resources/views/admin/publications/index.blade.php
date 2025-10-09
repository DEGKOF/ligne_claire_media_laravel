@extends('layouts.admin')

@section('page-title', 'Publications')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-black">Toutes les publications</h1>
    <a href="{{ route('admin.publications.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition flex items-center gap-2">
        <span class="text-xl">+</span> Nouvelle publication
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('admin.publications.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <!-- Search -->
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="🔍 Rechercher..."
               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">

        <!-- Rubrique -->
        <select name="rubrique_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            <option value="">Toutes les rubriques</option>
            @foreach($rubriques as $rubrique)
                <option value="{{ $rubrique->id }}" {{ request('rubrique_id') == $rubrique->id ? 'selected' : '' }}>
                    {{ $rubrique->icon }} {{ $rubrique->name }}
                </option>
            @endforeach
        </select>

        <!-- Status -->
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            <option value="">Tous les statuts</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publié</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
            <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Masqué</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
        </select>

        <!-- Type -->
        <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            <option value="">Tous les types</option>
            <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>Article</option>
            <option value="direct" {{ request('type') == 'direct' ? 'selected' : '' }}>Direct</option>
            <option value="rediffusion" {{ request('type') == 'rediffusion' ? 'selected' : '' }}>Rediffusion</option>
            <option value="video_courte" {{ request('type') == 'video_courte' ? 'selected' : '' }}>Vidéo courte</option>
            <option value="lien_externe" {{ request('type') == 'lien_externe' ? 'selected' : '' }}>Lien externe</option>
        </select>

        <!-- Submit -->
        <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-900 transition">
            Filtrer
        </button>
    </form>
</div>

<!-- Publications Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Publication
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Rubrique
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Auteur
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Type
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Vues
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($publications as $publication)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            @if($publication->featured_image)
                                <img class="h-12 w-12 rounded object-cover"
                                     src="{{ asset('storage/' . $publication->featured_image) }}"
                                     alt="">
                            @else
                                <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center text-gray-500">
                                    📰
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 max-w-md truncate">
                                {{ $publication->title }}
                            </div>
                            @if($publication->is_new)
                                <span class="text-xs font-semibold text-red-600">NEW</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900">
                        {{ $publication->rubrique->icon }} {{ $publication->rubrique->name }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $publication->user->public_name }}</div>
                    <div class="text-xs text-gray-500">{{ $publication->user->nom ." ". $publication->user->prenom ?? "" }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-xs font-semibold">
                        @switch($publication->type)
                            @case('article') 📰 Article @break
                            @case('direct') 🔴 Direct @break
                            @case('rediffusion') 📺 Rediffusion @break
                            @case('video_courte') 📹 Short @break
                            @case('lien_externe') 🔗 Externe @break
                        @endswitch
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @switch($publication->status)
                        @case('published')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Publié
                            </span>
                            @break
                        @case('draft')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Brouillon
                            </span>
                            @break
                        @case('hidden')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Masqué
                            </span>
                            @break
                        @case('archived')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Archivé
                            </span>
                            @break
                    @endswitch
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    👁️ {{ number_format($publication->views_count) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $publication->published_at?->format('d/m/Y') ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('publication.show', $publication->slug) }}"
                           target="_blank"
                           class="text-gray-600 hover:text-gray-900"
                           title="Voir">
                            👁️
                        </a>
                        <a href="{{ route('admin.publications.edit', $publication) }}"
                           class="text-blue-600 hover:text-blue-900"
                           title="Modifier">
                            ✏️
                        </a>
                        @if($publication->status !== 'published')
                            <form action="{{ route('admin.publications.publish', $publication) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-green-600 hover:text-green-900"
                                        title="Publier">
                                    ✓
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.publications.unpublish', $publication) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-orange-600 hover:text-orange-900"
                                        title="Masquer">
                                    👁️‍🗨️
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.publications.destroy', $publication) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-900"
                                    title="Supprimer">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                    <div class="text-4xl mb-4">📭</div>
                    <p class="text-lg">Aucune publication trouvée</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $publications->withQueryString()->links() }}
</div>
@endsection
