@extends('layouts.admin')

@section('page-title', 'Nouvelle Publication')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.publications.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Retour
            </a>
            <h1 class="text-3xl font-black">Nouvelle Publication</h1>
        </div>

        <form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Titre -->
            <div class="bg-white rounded-lg shadow p-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Titre de la publication *
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 text-lg font-semibold"
                    required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rubrique & Type -->
            <div class="bg-white rounded-lg shadow p-6 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Rubrique *
                    </label>
                    <select name="rubrique_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                        required>
                        <option value="">Sélectionner une rubrique</option>
                        @foreach ($rubriques as $rubrique)
                            <option value="{{ $rubrique->id }}" {{ old('rubrique_id') == $rubrique->id ? 'selected' : '' }}>
                                {{ $rubrique->icon }} {{ $rubrique->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('rubrique_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Type de publication *
                    </label>
                    <select name="type"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                        required>
                        <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>📰 Article</option>
                        <option value="direct" {{ old('type') == 'direct' ? 'selected' : '' }}>🔴 Direct</option>
                        <option value="rediffusion" {{ old('type') == 'rediffusion' ? 'selected' : '' }}>📺 Rediffusion
                        </option>
                        <option value="video_courte" {{ old('type') == 'video_courte' ? 'selected' : '' }}>📹 Vidéo courte
                        </option>
                        <option value="lien_externe" {{ old('type') == 'lien_externe' ? 'selected' : '' }}>🔗 Lien externe
                        </option>
                    </select>
                    @error('type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Résumé -->
            <div class="bg-white rounded-lg shadow p-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Résumé (Excerpt)
                </label>
                <textarea name="excerpt" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                    placeholder="Court résumé de la publication...">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contenu -->
            <div class="bg-white rounded-lg shadow p-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Contenu principal
                </label>
                <textarea name="content" id="editor" rows="15"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 font-mono text-sm">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">
                    {{-- 💡 Conseil : Utilisez un éditeur externe puis collez le contenu ici --}}
                </p>
            </div>

            <!-- Image & Médias -->
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h3 class="font-bold text-lg mb-4">Médias</h3>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Image à la une
                    </label>
                    <input type="file" name="featured_image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('featured_image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        URL Vidéo (YouTube, etc.)
                    </label>
                    <input type="url" name="video_url" value="{{ old('video_url') }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('video_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Lien externe
                    </label>
                    <input type="url" name="external_link" value="{{ old('external_link') }}" placeholder="https://..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('external_link')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Durée vidéo (secondes)
                    </label>
                    <input type="number" name="video_duration" value="{{ old('video_duration') }}" placeholder="120"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('video_duration')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Options -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Options de publication</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Statut *
                        </label>
                        <select name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>

                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin')
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié
                                </option>
                                <option value="hidden" {{ old('status') == 'hidden' ? 'selected' : '' }}>Masqué
                                </option>
                            @endif
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin')
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">⭐ Article à la une</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_breaking" value="1"
                                    {{ old('is_breaking') ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-600 rounded focus:ring-red-500">
                                <span class="text-sm font-medium text-gray-700">🚨 Flash info</span>
                            </label>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h3 class="font-bold text-lg mb-4">🔍 SEO (Optionnel)</h3>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Meta Titre
                    </label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Meta Description
                    </label>
                    <textarea name="meta_description" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">{{ old('meta_description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Mots-clés (séparés par des virgules)
                    </label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                        placeholder="politique, économie, france"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4 pb-8">
                <a href="{{ route('admin.publications.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Créer la publication
                </button>
            </div>
        </form>
    </div>
@endsection
