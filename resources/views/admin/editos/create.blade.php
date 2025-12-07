@extends('layouts.admin')

@section('title', 'Nouvel Édito')

@section('page-title', 'Nouvel Édito')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.editos.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="editoForm">
                    @csrf

                    <!-- Titre -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre de l'édito <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
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
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
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
                                  class="@error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
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
                                   value="{{ old('published_at') }}"
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
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
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
                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cover_image') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, WEBP. Max: 5MB</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Preview -->
                        <div id="coverPreview" class="mt-4 hidden">
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
                            <span>Publier l'édito</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar d'aide -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">À propos des éditos</h3>

                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Qu'est-ce qu'un édito ?</h4>
                        <p class="text-sm text-gray-600">
                            Un édito est un article d'opinion rédigé par un membre de la rédaction pour exprimer un point de vue.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Statuts</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><span class="font-medium">Brouillon:</span> Non visible publiquement</li>
                            <li><span class="font-medium">Publié:</span> Visible sur le site</li>
                            <li><span class="font-medium">Archivé:</span> Plus affiché en premier</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Affichage frontend</h4>
                        <p class="text-sm text-gray-600">
                            Le dernier édito publié apparaît en grand, suivi de la liste des anciens éditos.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg p-4 mt-6">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                    <p class="text-sm text-blue-800">
                        <strong>Astuce:</strong> Utilisez l'extrait pour contrôler ce qui s'affiche dans la liste. Sinon, un extrait sera généré automatiquement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview de l'image de couverture
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
