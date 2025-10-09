@extends('layouts.admin')

@section('page-title', 'Nouvelle Rubrique')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.rubriques.index') }}"
           class="text-gray-600 hover:text-gray-900">
            ← Retour
        </a>
        <h1 class="text-3xl font-black">Nouvelle Rubrique</h1>
    </div>

    <form action="{{ route('admin.rubriques.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nom -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Nom de la rubrique *
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Ex: Technologie, Sport, Culture..."
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 text-lg font-semibold"
                   required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-2">
                💡 Le slug sera généré automatiquement à partir du nom
            </p>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description"
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                      placeholder="Décrivez brièvement cette rubrique...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icône & Couleur -->
        <div class="bg-white rounded-lg shadow p-6 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Icône (Emoji)
                </label>
                <input type="text"
                       name="icon"
                       value="{{ old('icon') }}"
                       placeholder="📰"
                       maxlength="10"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 text-2xl text-center">
                @error('icon')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2 text-center">
                    Emoji représentant la rubrique
                </p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Couleur
                </label>
                <input type="color"
                       name="color"
                       value="{{ old('color', '#2563eb') }}"
                       class="w-full h-12 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 cursor-pointer">
                @error('color')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2 text-center">
                    Couleur thématique
                </p>
            </div>
        </div>

        <!-- Ordre -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Ordre d'affichage
            </label>
            <input type="number"
                   name="order"
                   value="{{ old('order', 0) }}"
                   min="0"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            @error('order')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-2">
                💡 Détermine l'ordre dans le menu de navigation (0 = premier)
            </p>
        </div>

        <!-- Statut -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                <div>
                    <span class="text-sm font-bold text-gray-700">Rubrique active</span>
                    <p class="text-xs text-gray-500">Visible sur le site frontend</p>
                </div>
            </label>
            @error('is_active')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Exemples d'icônes -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="font-bold text-sm text-gray-700 mb-3">💡 Suggestions d'icônes :</h3>
            <div class="grid grid-cols-8 gap-3 text-center">
                <button type="button" onclick="document.querySelector('input[name=icon]').value='📰'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">📰</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🏛️'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🏛️</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='💼'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">💼</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🏥'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🏥</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='⚽'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">⚽</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🎬'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🎬</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='💻'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">💻</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🌍'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🌍</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='⚖️'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">⚖️</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='⭐'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">⭐</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🌤️'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🌤️</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='📚'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">📚</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🚗'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🚗</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🎨'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🎨</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🔬'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🔬</button>
                <button type="button" onclick="document.querySelector('input[name=icon]').value='🎭'" class="text-3xl hover:scale-110 transition p-2 hover:bg-white rounded">🎭</button>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-4 pb-8">
            <a href="{{ route('admin.rubriques.index') }}"
               class="px-6 py-3 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition">
                Annuler
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                Créer la rubrique
            </button>
        </div>
    </form>
</div>
@endsection
