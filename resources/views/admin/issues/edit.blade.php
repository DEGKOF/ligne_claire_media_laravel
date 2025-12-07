@extends('layouts.admin')

@section('title', 'Modifier le journal')

@section('page-title', 'Modifier le journal #' . $issue->issue_number)

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.issues.update', $issue) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-2 text-amber-800">
                            <i class="fas fa-lock"></i>
                            <p class="text-sm font-medium">
                                Numéro du journal : <strong class="text-lg">{{ $issue->issue_number }}</strong>
                                (non modifiable)
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
                                   value="{{ old('published_at', $issue->published_at->format('Y-m-d')) }}"
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
                               value="{{ old('title', $issue->title) }}"
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
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $issue->description) }}</textarea>
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
                                   value="{{ old('price', $issue->price) }}"
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
                                   value="{{ old('digital_price', $issue->digital_price) }}"
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
                                   value="{{ old('stock_quantity', $issue->stock_quantity) }}"
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
                            <option value="draft" {{ old('status', $issue->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                            <option value="published" {{ old('status', $issue->status) == 'published' ? 'selected' : '' }}>Publié</option>
                            <option value="archived" {{ old('status', $issue->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
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

                        @if($issue->cover_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Image actuelle:</p>
                            <img src="{{ asset('storage/' . $issue->cover_image) }}"
                                 alt="{{ $issue->title }}"
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

                    <!-- Fichier PDF -->
                    <div class="mb-6">
                        <label for="pdf_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Fichier PDF du journal
                        </label>

                        @if($issue->pdf_file)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">PDF actuel:</p>
                            <a href="{{ asset('storage/' . $issue->pdf_file) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                                <i class="fas fa-file-pdf"></i>
                                <span>Voir le PDF actuel</span>
                            </a>
                        </div>
                        @endif

                        <input type="file"
                               id="pdf_file"
                               name="pdf_file"
                               accept="application/pdf"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pdf_file') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver le PDF actuel. Format: PDF. Max: 50MB</p>
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
                        <span class="text-gray-600">Créé le:</span>
                        <p class="font-medium text-gray-900">{{ $issue->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Dernière modification:</span>
                        <p class="font-medium text-gray-900">{{ $issue->updated_at->format('d/m/Y à H:i') }}</p>
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
                        Supprimer ce journal l'archivera. Vous pourrez le restaurer plus tard.
                    </p>
                    <form action="{{ route('admin.issues.destroy', $issue) }}"
                          method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir archiver ce journal ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-archive"></i>
                            <span>Archiver ce journal</span>
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
