@extends('layouts.admin')

@section('title', 'Ajouter un journal')

@section('page-title', 'Ajouter un journal')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.issues.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-2 text-blue-800">
                            <i class="fas fa-info-circle"></i>
                            <p class="text-sm font-medium">
                                Le numéro du journal sera généré automatiquement au format <strong>AANNNN</strong>
                                (Ex: 250001 pour le 1er journal de 2025)
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Date de publication -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de publication <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   id="published_at"
                                   name="published_at"
                                   value="{{ old('published_at', date('Y-m-d')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror"
                                   required>
                            @error('published_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Titre -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Ex: Mercredi 15 Octobre 2025"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Description du contenu de ce numéro..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Prix papier -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Prix papier (FCFA) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   step="50"
                                   value="{{ old('price', 200) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                   required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prix digital -->
                        <div>
                            <label for="digital_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Prix digital (FCFA) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="digital_price"
                                   name="digital_price"
                                   step="50"
                                   value="{{ old('digital_price', 200) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('digital_price') border-red-500 @enderror"
                                   required>
                            @error('digital_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock disponible <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="stock_quantity"
                                   name="stock_quantity"
                                   value="{{ old('stock_quantity', 100) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror"
                                   required>
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="mb-6">
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

                    <!-- Image de couverture -->
                    <div class="mb-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Image de couverture
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

                    <!-- Fichier PDF -->
                    <div class="mb-6">
                        <label for="pdf_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Fichier PDF du journal
                        </label>
                        <input type="file"
                               id="pdf_file"
                               name="pdf_file"
                               accept="application/pdf"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pdf_file') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Format: PDF. Max: 50MB</p>
                        @error('pdf_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.issues.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar d'aide -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aide</h3>

                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Numérotation automatique</h4>
                        <p class="text-sm text-gray-600">
                            Le système génère automatiquement un numéro unique au format <strong>AANNNN</strong> :
                        </p>
                        <ul class="text-sm text-gray-600 mt-2 space-y-1 list-disc list-inside">
                            <li><strong>AA</strong> = 2 derniers chiffres de l'année</li>
                            <li><strong>NNNN</strong> = Numéro séquentiel sur 4 chiffres</li>
                            <li>Exemple : 250001, 250002, 250003...</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Statuts</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><span class="font-medium">Brouillon:</span> Non visible par les utilisateurs</li>
                            <li><span class="font-medium">Publié:</span> Visible et achetable</li>
                            <li><span class="font-medium">Archivé:</span> Ancien numéro, consultation limitée</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Fichiers</h4>
                        <p class="text-sm text-gray-600">
                            Le PDF sera accessible aux utilisateurs après achat, sans nécessité de connexion.
                        </p>
                    </div>
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
