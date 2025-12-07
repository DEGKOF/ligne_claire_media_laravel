@extends('layouts.admin')

@section('title', 'Modifier l\'édito')

@section('page-title', 'Modifier l\'édito')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.editos.update', $edito) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="editoForm">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre de l'édito <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $edito->title) }}"
                               placeholder="Ex: Réflexions sur l'année 2025"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Extrait -->
                    <div class="mb-6">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Extrait / Résumé court
                        </label>
                        <textarea id="excerpt"
                                  name="excerpt"
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Résumé court qui apparaîtra dans la liste des éditos (max 500 caractères)"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $edito->excerpt) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Facultatif - Laissez vide pour générer automatiquement depuis le contenu</p>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu avec CKEditor -->
                    <div class="mb-6">
                        <label for="editor" class="block text-sm font-medium text-gray-700 mb-2">
                            Contenu de l'édito <span class="text-red-500">*</span>
                        </label>
                        <textarea id="editor"
                                  name="content"
                                  class="@error('content') border-red-500 @enderror">{{ old('content', $edito->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Date de publication -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de publication
                            </label>
                            <input type="datetime-local"
                                   id="published_at"
                                   name="published_at"
                                   value="{{ old('published_at', $edito->published_at ? $edito->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Laissez vide pour la date actuelle si statut "Publié"</p>
                            @error('published_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Statut <span class="text-red-500">*</span>
                            </label>
                            <select id="status"
                                    name="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                                    required>
                                <option value="draft" {{ old('status', $edito->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="published" {{ old('status', $edito->status) == 'published' ? 'selected' : '' }}>Publié</option>
                                <option value="archived" {{ old('status', $edito->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image de couverture -->
                    <div class="mb-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Image de couverture (optionnelle)
                        </label>

                        @if($edito->cover_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Image actuelle:</p>
                            <img src="{{ asset('storage/'. $edito->cover_image) }}"
                                 alt="{{ $edito->title }}"
                                 class="max-w-xs rounded-lg shadow-sm">
                        </div>
                        @endif

                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cover_image') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver l'image actuelle. Format: JPG, PNG, WEBP. Max: 5MB</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Preview nouvelle image -->
                        <div id="coverPreview" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2">Nouvelle image:</p>
                            <img id="coverPreviewImg" src="" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.editos.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Mettre à jour</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-600">Auteur:</span>
                        <p class="font-medium text-gray-900">
                            {{ $edito->user->prenom ?? $edito->user->username ?? 'Inconnu' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-600">Créé le:</span>
                        <p class="font-medium text-gray-900">{{ $edito->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Dernière modification:</span>
                        <p class="font-medium text-gray-900">{{ $edito->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Slug:</span>
                        <p class="font-mono text-xs text-gray-900 bg-gray-50 px-2 py-1 rounded mt-1">
                            {{ $edito->slug }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Aperçu -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Aperçu</p>
                        <p class="mb-3">Vous pouvez prévisualiser votre édito avant de le publier.</p>
                        <a href="{{ route('admin.editos.show', $edito) }}"
                           class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-900 font-medium">
                            <i class="fas fa-eye"></i>
                            Voir l'aperçu
                        </a>
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
                        Supprimer cet édito l'archivera. Vous pourrez le restaurer plus tard.
                    </p>
                    <form action="{{ route('admin.editos.destroy', $edito) }}"
                          method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir archiver cet édito ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-archive"></i>
                            <span>Archiver cet édito</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview de la nouvelle image
document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverPreviewImg').src = e.target.result;
            document.getElementById('coverPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
