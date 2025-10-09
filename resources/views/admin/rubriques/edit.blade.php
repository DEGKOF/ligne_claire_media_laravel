@extends('layouts.admin')

@section('page-title', 'Modifier : ' . $rubrique->name)

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.rubriques.index') }}"
               class="text-gray-600 hover:text-gray-900">
                ← Retour
            </a>
            <h1 class="text-3xl font-black">Modifier la Rubrique</h1>
        </div>
        <a href="{{ route('rubrique.show', $rubrique->slug) }}"
           target="_blank"
           class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
            👁️ Voir
        </a>
    </div>

    <form action="{{ route('admin.rubriques.update', $rubrique) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nom -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Nom de la rubrique *
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $rubrique->name) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 text-lg font-semibold"
                   required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div class="mt-2 text-sm text-gray-500">
                <strong>Slug actuel :</strong> <code class="bg-gray-100 px-2 py-1 rounded">{{ $rubrique->slug }}</code>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description"
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                      placeholder="Décrivez brièvement cette rubrique...">{{ old('description', $rubrique->description) }}</textarea>
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
                       value="{{ old('icon', $rubrique->icon) }}"
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
                       value="{{ old('color', $rubrique->color ?? '#2563eb') }}"
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
                   value="{{ old('order', $rubrique->order) }}"
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
                       {{ old('is_active', $rubrique->is_active) ? 'checked' : '' }}
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

        <!-- Statistiques -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="font-bold text-lg mb-4">📊 Statistiques</h3>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-white rounded-lg p-4">
                    <div class="text-3xl font-bold text-gray-900">{{ $rubrique->publications()->count() }}</div>
                    <div class="text-sm text-gray-600">Publications</div>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($rubrique->views_count) }}</div>
                    <div class="text-sm text-gray-600">Vues totales</div>
                </div>
            </div>
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
        <div class="flex justify-between pb-8">
            {{-- @if($rubrique->publications()->count() === 0)
            <form action="{{ route('admin.rubriques.destroy', $rubrique) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette rubrique ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-3 border-2 border-red-600 text-red-600 rounded-lg font-bold hover:bg-red-50 transition">
                    🗑️ Supprimer
                </button>
            </form>
            @else
            <div class="px-6 py-3 border-2 border-gray-300 text-gray-400 rounded-lg font-bold cursor-not-allowed">
                🗑️ Suppression impossible
                <div class="text-xs font-normal mt-1">Contient {{ $rubrique->publications()->count() }} publication(s)</div>
            </div>
            @endif --}}

            <div class="flex gap-4">
                <a href="{{ route('admin.rubriques.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    💾 Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
