@extends('layouts.admin')

@section('title', 'Détails de la soumission')
@section('page-title', 'Soumission Communauté')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.community.index') }}"
           class="text-blue-600 hover:text-blue-800 font-medium">
            ← Retour à la liste
        </a>
    </div>
</div>

<!-- Actions rapides -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <div class="flex flex-wrap gap-3">
        @if($submission->status === 'pending')
        <form method="POST" action="{{ route('admin.community.validate', $submission) }}" class="inline">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                ✓ Valider
            </button>
        </form>

        <form method="POST" action="{{ route('admin.community.reject', $submission) }}" class="inline">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette soumission ?')">
                ✗ Rejeter
            </button>
        </form>
        @endif

        @if($submission->status === 'validated' && !$submission->published_at)
        <form method="POST" action="{{ route('admin.community.publish', $submission) }}" class="inline">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Publier
            </button>
        </form>
        @endif

        @if($submission->published_at)
        <form method="POST" action="{{ route('admin.community.unpublish', $submission) }}" class="inline">
            @csrf
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Dépublier
            </button>
        </form>
        @endif

        <button onclick="document.getElementById('editForm').classList.toggle('hidden')"
                class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                Modifier
        </button>

        <form method="POST" action="{{ route('admin.community.destroy', $submission) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?')">
                    Supprimer
            </button>
        </form>
    </div>
</div>

<!-- Formulaire de modification (caché par défaut) -->
<div id="editForm" class="hidden bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Modifier la soumission</h3>

    <form method="POST" action="{{ route('admin.community.update', $submission) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="article" {{ $submission->type === 'article' ? 'selected' : '' }}>Article</option>
                    <option value="info" {{ $submission->type === 'info' ? 'selected' : '' }}>Information</option>
                    <option value="alert" {{ $submission->type === 'alert' ? 'selected' : '' }}>Alerte</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="validated" {{ $submission->status === 'validated' ? 'selected' : '' }}>Validé</option>
                    <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                    <option value="published" {{ $submission->status === 'published' ? 'selected' : '' }}>Publié</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
            <input type="text" name="title" value="{{ old('title', $submission->title) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Contenu</label>
            <textarea name="content" id="editor" rows="10"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                      required>{{ old('content', $submission->summary) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
            <input type="text" name="location" value="{{ old('location', $submission->location) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes administratives</label>
            <textarea name="admin_notes" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('admin_notes', $submission->admin_notes) }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Ces notes sont privées et ne seront pas visibles par l'auteur</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Enregistrer les modifications
            </button>
            <button type="button" onclick="document.getElementById('editForm').classList.add('hidden')"
                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </button>
        </div>
    </form>
</div>

<!-- Informations principales -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Contenu principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Détails de la soumission -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $submission->type === 'article' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $submission->type === 'info' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $submission->type === 'alert' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($submission->type) }}
                    </span>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $submission->status === 'validated' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $submission->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : '' }}">
                        @switch($submission->status)
                            @case('pending') En attente @break
                            @case('validated') Validé @break
                            @case('rejected') Rejeté @break
                            @case('published') Publié @break
                        @endswitch
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $submission->title }}</h2>
                @if($submission->location)
                <p class="text-gray-600 flex items-center gap-2">
                    📍 {{ $submission->location }}
                </p>
                @endif
            </div>

            <div class="prose max-w-none">
                {!! nl2br(e($submission->content)) !!}
            </div>

            @if($submission->attachments && count($submission->attachments) > 0)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pièces jointes</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($submission->attachments as $attachment)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <p class="text-sm text-gray-600 truncate">{{ $attachment['name'] ?? 'Fichier' }}</p>
                        <a href="{{ $attachment['url'] }}" target="_blank"
                           class="text-sm text-blue-600 hover:text-blue-800">
                            Télécharger
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($submission->admin_notes)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes administratives</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    {!! nl2br(e($submission->admin_notes)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Informations de l'auteur -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Auteur</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nom</p>
                    <p class="font-medium text-gray-900">{{ $submission->user->nom ." ". $submission->user->prenom }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-900">
                        <a href="mailto:{{ $submission->user->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $submission->user->email }}
                        </a>
                    </p>
                </div>
                @if($submission->user->phone)
                <div>
                    <p class="text-sm text-gray-500">Téléphone</p>
                    <p class="font-medium text-gray-900">{{ $submission->user->phone }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500">Créé le</p>
                    <p class="font-medium text-gray-900">{{ $submission->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Mis à jour le</p>
                    <p class="font-medium text-gray-900">{{ $submission->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($submission->validated_at)
                <div>
                    <p class="text-gray-500">Validé le</p>
                    <p class="font-medium text-gray-900">{{ $submission->validated_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
                @if($submission->published_at)
                <div>
                    <p class="text-gray-500">Publié le</p>
                    <p class="font-medium text-gray-900">{{ $submission->published_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
                @if($submission->validated_by)
                <div>
                    <p class="text-gray-500">Validé par</p>
                    <p class="font-medium text-gray-900">{{ $submission->validator->username ?? 'N/A' }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        @if($submission->published_at)
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Vues</span>
                    <span class="font-bold text-gray-900">{{ $submission->views_count ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Partages</span>
                    <span class="font-bold text-gray-900">{{ $submission->shares_count ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Commentaires</span>
                    <span class="font-bold text-gray-900">{{ $submission->comments_count ?? 0 }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    if (document.getElementById('editor')) {
        CKEDITOR.replace('editor', {
            height: 400
        });
    }
</script>
@endpush
