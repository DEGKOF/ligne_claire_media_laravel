@extends('layouts.admin')

@section('page-title', 'Modifier : ' . $publication->title)

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.publications.index') }}"
               class="text-gray-600 hover:text-gray-900">
                ← Retour
            </a>
            <h1 class="text-3xl font-black">Modifier la Publication</h1>
        </div>
        <a href="{{ route('publication.show', $publication->slug) }}"
           target="_blank"
           class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
            Voir
        </a>
    </div>

    <form action="{{ route('admin.publications.update', $publication) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Titre -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Titre de la publication *
            </label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $publication->title) }}"
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
                    @foreach($rubriques as $rubrique)
                        <option value="{{ $rubrique->id }}" {{ old('rubrique_id', $publication->rubrique_id) == $rubrique->id ? 'selected' : '' }}>
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
                    <option value="article" {{ old('type', $publication->type) == 'article' ? 'selected' : '' }}>📰 Article</option>
                    {{-- <option value="direct" {{ old('type', $publication->type) == 'direct' ? 'selected' : '' }}>🔴 Direct</option>
                    <option value="rediffusion" {{ old('type', $publication->type) == 'rediffusion' ? 'selected' : '' }}>📺 Rediffusion</option>
                    <option value="video_courte" {{ old('type', $publication->type) == 'video_courte' ? 'selected' : '' }}>📹 Vidéo courte</option>
                    <option value="lien_externe" {{ old('type', $publication->type) == 'lien_externe' ? 'selected' : '' }}>🔗 Lien externe</option> --}}
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
            <textarea name="excerpt"
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                      placeholder="Court résumé de la publication...">{{ old('excerpt', $publication->excerpt) }}</textarea>
            @error('excerpt')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contenu -->
        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Contenu principal
            </label>
            <textarea name="content"
            id="editor"
                      rows="15"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 font-mono text-sm">{{ old('content', $publication->content) }}</textarea>
            @error('content')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image & Médias -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="font-bold text-lg mb-4">Médias</h3>

            {{-- <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Image à la une
                </label>
                @if($publication->featured_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $publication->featured_image) }}"
                             alt="Image actuelle"
                             class="h-32 w-auto rounded border border-gray-300">
                        <p class="text-sm text-gray-500 mt-1">Image actuelle</p>
                    </div>
                @endif
                <input type="file"
                       name="featured_image"
                       accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                <p class="text-sm text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
                @error('featured_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Média à la une (Image ou Vidéo)
                </label>
                @if($publication->featured_image)
                    <div class="mb-3">
                        @php
                            $extension = pathinfo($publication->featured_image, PATHINFO_EXTENSION);
                            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                        @endphp

                        @if($isVideo)
                            <video controls class="h-48 w-auto rounded border border-gray-300">
                                <source src="{{ asset('storage/' . $publication->featured_image) }}" type="video/{{ $extension }}">
                                Votre navigateur ne supporte pas la lecture vidéo.
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $publication->featured_image) }}"
                                alt="Image actuelle"
                                class="h-32 w-auto rounded border border-gray-300">
                        @endif
                        <p class="text-sm text-gray-500 mt-1">Média actuel</p>
                    </div>
                @endif
                <input type="file"
                    name="featured_image"
                    accept="image/*,video/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                    onchange="previewMedia(event)">
                <p class="text-sm text-gray-500 mt-1">Image (Max: 2 Mo) ou Vidéo (Max: 50 Mo). Laissez vide pour conserver le média actuel.</p>

                <!-- Prévisualisation -->
                <div id="mediaPreview" class="mt-3"></div>

                @error('featured_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    URL Vidéo (YouTube, etc.)
                </label>
                <input type="url"
                       name="video_url"
                       value="{{ old('video_url', $publication->video_url) }}"
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
                <input type="url"
                       name="external_link"
                       value="{{ old('external_link', $publication->external_link) }}"
                       placeholder="https://..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                @error('external_link')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Durée vidéo (secondes)
                </label>
                <input type="number"
                       name="video_duration"
                       value="{{ old('video_duration', $publication->video_duration) }}"
                       placeholder="120"
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
                            required
                            {{ (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin') ? "" : "disabled" }}
                            >
                        <option value="draft" {{ old('status', $publication->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status', $publication->status) == 'published' ? 'selected' : '' }}>Publié</option>
                        {{-- <option value="hidden" {{ old('status', $publication->status) == 'hidden' ? 'selected' : '' }}>Masqué</option>
                        <option value="archived" {{ old('status', $publication->status) == 'archived' ? 'selected' : '' }}>Archivé</option> --}}
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                               name="is_featured"
                               value="1"
                               {{ old('is_featured', $publication->is_featured) ? 'checked' : '' }}
                               {{ (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin') ? "" : "disabled" }}
                               class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">⭐ Article à la une</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                               name="is_breaking"
                               value="1"
                               {{ old('is_breaking', $publication->is_breaking) ? 'checked' : '' }}
                               {{ (Auth::user()->role === 'admin' || Auth::user()->role === 'master_admin') ? "" : "disabled" }}
                               class="w-5 h-5 text-red-600 rounded focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">🚨 Flash info</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- SEO -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="font-bold text-lg mb-4">🔍 SEO</h3>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Meta Titre
                </label>
                <input type="text"
                       name="meta_title"
                       value="{{ old('meta_title', $publication->meta_title) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Meta Description
                </label>
                <textarea name="meta_description"
                          rows="2"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">{{ old('meta_description', $publication->meta_description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Mots-clés (séparés par des virgules)
                </label>
                <input type="text"
                       name="meta_keywords"
                       value="{{ old('meta_keywords', $publication->meta_keywords) }}"
                       placeholder="politique, économie, france"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
            <h3 class="font-bold text-lg mb-4">Statistiques</h3>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($publication->views_count) }}</div>
                    <div class="text-sm text-gray-600">Vues</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $publication->comments_count }}</div>
                    <div class="text-sm text-gray-600">Commentaires</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $publication->shares_count }}</div>
                    <div class="text-sm text-gray-600">Partages</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between pb-8">
            {{-- <form action="{{ route('admin.publications.destroy', $publication) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-3 border-2 border-red-600 text-red-600 rounded-lg font-bold hover:bg-red-50 transition">
                    🗑️ Supprimer
                </button>
            </form> --}}

            <div class="flex gap-4">
                <a href="{{ route('admin.publications.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
