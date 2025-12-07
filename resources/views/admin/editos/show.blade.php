@extends('layouts.admin')

@section('title', 'Aperçu de l\'édito')

@section('page-title', 'Aperçu de l\'édito')

@section('content')
<div class="mb-6">
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.editos.edit', $edito) }}"
           class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-edit"></i>
            <span>Modifier</span>
        </a>
        <a href="{{ route('admin.editos.index') }}"
           class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Carte principale -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- En-tête avec badges -->
            <div class="flex flex-wrap items-center gap-3 mb-6 pb-6 border-b border-gray-200">
                {!! $edito->status_badge !!}

                @if($edito->published_at)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $edito->published_at->format('d/m/Y à H:i') }}
                </span>
                @endif

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    <i class="fas fa-link mr-1"></i>
                    {{ $edito->slug }}
                </span>
            </div>

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $edito->title }}</h1>

            <!-- Auteur et métadonnées -->
            <div class="flex flex-wrap items-center gap-6 mb-6 pb-6 border-b border-gray-200">
                <!-- Auteur -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($edito->user->nom ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Auteur</div>
                        <div class="font-semibold text-gray-900">
                            {{ $edito->user->prenom ?? $edito->user->username ?? 'Inconnu' }}
                        </div>
                    </div>
                </div>

                <!-- Temps de lecture -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-500">Lecture estimée</div>
                        <div class="font-medium text-gray-900">
                            {{ ceil(str_word_count(strip_tags($edito->content)) / 200) }} min
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image de couverture -->
            @if($edito->cover_image)
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Image de couverture</h3>
                <img src="{{ asset('storage/'. $edito->cover_image) }}"
                     alt="{{ $edito->title }}"
                     class="w-full rounded-lg shadow-md">
            </div>
            @endif

            <!-- Extrait -->
            @if($edito->excerpt)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-600">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Extrait / Résumé</h3>
                <p class="text-gray-700 italic">{{ $edito->excerpt }}</p>
            </div>
            @endif

            <!-- Contenu -->
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Contenu</h3>
                <div class="prose prose-lg max-w-none p-6 bg-gray-50 rounded-lg">
                    {!! $edito->content !!}
                </div>
            </div>
        </div>

        <!-- Aperçu URL publique -->
        @if($edito->isPublished())
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-globe text-green-600 text-xl mt-1"></i>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-900 mb-2">Édito publié</h3>
                    <p class="text-sm text-green-700 mb-3">
                        Cet édito est visible publiquement à l'adresse suivante :
                    </p>
                    <a href="{{ route('editos.show', $edito->slug) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-external-link-alt"></i>
                        Voir sur le site public
                    </a>
                </div>
            </div>
        </div>
        @elseif($edito->status === 'draft')
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1"></i>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-900 mb-1">Brouillon non publié</h3>
                    <p class="text-sm text-yellow-700">
                        Cet édito est en brouillon et n'est pas visible sur le site public.
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-archive text-gray-600 text-xl mt-1"></i>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Édito archivé</h3>
                    <p class="text-sm text-gray-700">
                        Cet édito est archivé et n'apparaît plus en premier sur le site.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
            <div class="space-y-3">
                @if($edito->status === 'draft')
                    <form action="{{ route('admin.editos.update-status', $edito) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Publier l'édito</span>
                        </button>
                    </form>
                @elseif($edito->status === 'published')
                    <form action="{{ route('admin.editos.update-status', $edito) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="archived">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-archive"></i>
                            <span>Archiver</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.editos.update-status', $edito) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Republier</span>
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.editos.edit', $edito) }}"
                   class="block w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-center">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>

                @if($edito->isPublished())
                <a href="{{ route('editos.show', $edito->slug) }}"
                   target="_blank"
                   class="block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-center">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Voir en ligne</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-gray-600 block mb-1">Créé le</span>
                    <p class="font-medium text-gray-900">{{ $edito->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 block mb-1">Dernière modification</span>
                    <p class="font-medium text-gray-900">{{ $edito->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($edito->published_at)
                <div>
                    <span class="text-gray-600 block mb-1">Date de publication</span>
                    <p class="font-medium text-gray-900">{{ $edito->published_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
                @if($edito->deleted_at)
                <div>
                    <span class="text-gray-600 block mb-1">Supprimé le</span>
                    <p class="font-medium text-red-600">{{ $edito->deleted_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Informations techniques -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-gray-600">Nombre de mots</span>
                    <p class="font-medium text-gray-900">
                        {{ str_word_count(strip_tags($edito->content)) }} mots
                    </p>
                </div>
                <div>
                    <span class="text-gray-600">Nombre de caractères</span>
                    <p class="font-medium text-gray-900">
                        {{ strlen(strip_tags($edito->content)) }} caractères
                    </p>
                </div>
                <div>
                    <span class="text-gray-600">Slug</span>
                    <p class="font-mono text-xs text-gray-900 bg-gray-50 px-2 py-1 rounded mt-1">
                        {{ $edito->slug }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Zone dangereuse -->
        <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
            <div class="bg-red-600 px-6 py-3">
                <h3 class="text-lg font-semibold text-white">Zone dangereuse</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    La suppression archivera cet édito. Vous pourrez le restaurer ultérieurement.
                </p>
                <form action="{{ route('admin.editos.destroy', $edito) }}"
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir archiver cet édito ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Supprimer l'édito</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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

.prose h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
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

.prose figure.media {
    margin: 1.5rem 0;
}

.prose figure.media iframe {
    width: 100%;
    aspect-ratio: 16/9;
}
</style>
@endsection
