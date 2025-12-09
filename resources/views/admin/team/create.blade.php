@extends('layouts.admin')

@section('page-title', 'Ajouter un membre')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <!-- Retour -->
        <div class="mb-6">
            <a href="{{ route('admin.team.index') }}"
                class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ajouter un membre de l'équipe</h2>

        <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="prenom" name="prenom" required
                        value="{{ old('prenom') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nom" name="nom" required
                        value="{{ old('nom') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Poste -->
            <div>
                <label for="poste" class="block text-sm font-medium text-gray-700 mb-2">
                    Poste / Fonction <span class="text-red-500">*</span>
                </label>
                <input type="text" id="poste" name="poste" required
                    value="{{ old('poste') }}"
                    placeholder="Ex: Rédacteur en chef, Journaliste, Photographe..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('poste') border-red-500 @enderror">
                @error('poste')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <input type="text" id="telephone" name="telephone"
                        value="{{ old('telephone') }}"
                        placeholder="+229 XX XX XX XX"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror">
                    @error('telephone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="exemple@email.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Photo -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    Photo (optionnelle)
                </label>
                <input type="file" id="photo" name="photo" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('photo') border-red-500 @enderror">
                @error('photo')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Formats acceptés : JPG, PNG, GIF. Taille max : 2 Mo.
                </p>
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Biographie / Description (optionnelle)
                </label>
                <textarea id="bio" name="bio" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                    placeholder="Quelques mots sur ce membre...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ordre -->
            <div>
                <label for="ordre" class="block text-sm font-medium text-gray-700 mb-2">
                    Ordre d'affichage
                </label>
                <input type="number" id="ordre" name="ordre" min="0"
                    value="{{ old('ordre', 0) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ordre') border-red-500 @enderror">
                @error('ordre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Plus le nombre est petit, plus le membre apparaîtra en premier.
                </p>
            </div>

            <!-- Visibilité -->
            <div class="flex items-start gap-3">
                <input type="checkbox" id="is_visible" name="is_visible" value="1"
                    {{ old('is_visible', true) ? 'checked' : '' }}
                    class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_visible" class="text-sm text-gray-700">
                    <span class="font-medium">Afficher sur le site</span>
                    <p class="text-gray-500 mt-1">Si décoché, ce membre ne sera pas visible sur la page publique.</p>
                </label>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t">
                <a href="{{ route('admin.team.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
