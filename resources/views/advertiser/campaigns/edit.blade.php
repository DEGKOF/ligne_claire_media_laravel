@extends('layouts.admin')

@section('title', 'Éditer la campagne')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Éditer la campagne</h1>
            <p class="text-gray-600 mt-1">{{ $campaign->name }}</p>
        </div>
        <a href="{{ route('advertiser.campaigns.show', $campaign) }}"
           class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Annuler
        </a>
    </div>

    <!-- Alertes -->
    @if($campaign->status === 'rejected')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <h3 class="text-sm font-medium text-red-800">Campagne rejetée</h3>
            <p class="mt-1 text-sm text-red-700">{{ $campaign->rejection_reason }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('advertiser.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informations générales -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations générales</h2>

            <div class="space-y-4">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nom de la campagne <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $campaign->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emplacement -->
                <div>
                    <label for="placement_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Emplacement <span class="text-red-500">*</span>
                    </label>
                    <select name="placement_id" id="placement_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('placement_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner un emplacement</option>
                        @foreach($placements as $placement)
                            <option value="{{ $placement->id }}"
                                    {{ old('placement_id', $campaign->placement_id) == $placement->id ? 'selected' : '' }}>
                                {{ $placement->name }} - {{ $placement->price_format }}
                            </option>
                        @endforeach
                    </select>
                    @error('placement_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contenu publicitaire -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Contenu publicitaire</h2>

            <div class="space-y-4">
                <!-- Type de contenu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Type de contenu <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="content_type" value="image"
                                   {{ old('content_type', $campaign->content_type) === 'image' ? 'checked' : '' }}
                                   class="mr-2" required>
                            <span>Image</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="content_type" value="video"
                                   {{ old('content_type', $campaign->content_type) === 'video' ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Vidéo</span>
                        </label>
                    </div>
                    @error('content_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IMAGE SECTION -->
                <div id="content-image" style="display:none;">
                    <!-- Image actuelle -->
                    @if($campaign->image_url)
                        <div id="current-image" class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                            <div class="border border-gray-200 rounded-lg overflow-hidden max-w-md">
                                <img src="{{ $campaign->image_url }}" alt="Image actuelle" class="w-full">
                            </div>
                        </div>
                    @endif

                    <!-- Upload image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $campaign->image_url ? 'Remplacer l\'image' : 'Image' }}
                            @if(!$campaign->image_url) <span class="text-red-500">*</span> @endif
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG ou GIF. Max 2 Mo</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- VIDEO SECTION -->
                <div id="content-video" style="display:none;">
                    <!-- Vidéo actuelle -->
                    @if($campaign->video_url || $campaign->video_path)
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-1">Vidéo actuelle :</p>
                            @if($campaign->video_path)
                                <p class="text-sm text-gray-600">📁 Fichier uploadé</p>
                            @else
                                <p class="text-sm text-gray-600">🔗 {{ $campaign->video_url }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Choisir le type de vidéo</label>
                            <div class="flex gap-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="video_type" value="url"
                                           {{ old('video_type', $campaign->video_path ? 'file' : 'url') === 'url' ? 'checked' : '' }}
                                           class="mr-2">
                                    <span class="text-sm">Lien YouTube/Vimeo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="video_type" value="file"
                                           {{ old('video_type', $campaign->video_path ? 'file' : 'url') === 'file' ? 'checked' : '' }}
                                           class="mr-2">
                                    <span class="text-sm">Fichier vidéo</span>
                                </label>
                            </div>
                        </div>

                        <div id="video-url-input" style="display:none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $campaign->video_url) }}"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">YouTube, Vimeo, etc.</p>
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="video-file-input" style="display:none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $campaign->video_path ? 'Remplacer le fichier vidéo' : 'Fichier vidéo' }}
                            </label>
                            <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Formats : MP4, WebM (max 50MB)</p>
                            @error('video_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Titre -->
                <div>
                    <label for="headline" class="block text-sm font-medium text-gray-700 mb-1">
                        Titre
                    </label>
                    <input type="text" name="headline" id="headline" value="{{ old('headline', $campaign->headline) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('headline') border-red-500 @enderror"
                           maxlength="255">
                    @error('headline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Légende -->
                <div>
                    <label for="caption" class="block text-sm font-medium text-gray-700 mb-1">
                        Description courte
                    </label>
                    <textarea name="caption" id="caption" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('caption') border-red-500 @enderror">{{ old('caption', $campaign->caption) }}</textarea>
                    @error('caption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton CTA -->
                <div>
                    <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-1">
                        Texte du bouton d'action
                    </label>
                    <input type="text" name="cta_text" id="cta_text" value="{{ old('cta_text', $campaign->cta_text) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cta_text') border-red-500 @enderror"
                           maxlength="50" placeholder="En savoir plus">
                    @error('cta_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL de destination -->
                <div>
                    <label for="target_url" class="block text-sm font-medium text-gray-700 mb-1">
                        URL de destination <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="target_url" id="target_url" value="{{ old('target_url', $campaign->target_url) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('target_url') border-red-500 @enderror"
                           placeholder="https://" required>
                    @error('target_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nouvel onglet -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="open_new_tab" value="1"
                               {{ old('open_new_tab', $campaign->open_new_tab) ? 'checked' : '' }}
                               class="mr-2">
                        <span class="text-sm text-gray-700">Ouvrir dans un nouvel onglet</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Planification et budget -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Planification et budget</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Date de début -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="start_date" id="start_date"
                           value="{{ old('start_date', $campaign->start_date->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_date') border-red-500 @enderror"
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="end_date" id="end_date"
                           value="{{ old('end_date', $campaign->end_date->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_date') border-red-500 @enderror"
                           required>
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget total -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">
                        Budget total (FCFA)
                    </label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget', $campaign->budget) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('budget') border-red-500 @enderror"
                           min="0" step="1000">
                    @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget quotidien -->
                <div>
                    <label for="daily_budget" class="block text-sm font-medium text-gray-700 mb-1">
                        Budget quotidien (FCFA)
                    </label>
                    <input type="number" name="daily_budget" id="daily_budget" value="{{ old('daily_budget', $campaign->daily_budget) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('daily_budget') border-red-500 @enderror"
                           min="0" step="1000">
                    @error('daily_budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Ciblage -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ciblage <span class="text-sm font-normal text-gray-500">(optionnel)</span></h2>

            <div class="space-y-4">
                <!-- Appareils -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appareils ciblés</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="target_devices[]" value="desktop"
                                   {{ in_array('desktop', old('target_devices', $campaign->target_devices ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Desktop</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_devices[]" value="mobile"
                                   {{ in_array('mobile', old('target_devices', $campaign->target_devices ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Mobile</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_devices[]" value="tablet"
                                   {{ in_array('tablet', old('target_devices', $campaign->target_devices ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Tablette</span>
                        </label>
                    </div>
                </div>

                <!-- Pages -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pages ciblées</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="target_pages[]" value="home"
                                   {{ in_array('home', old('target_pages', $campaign->target_pages ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Accueil</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_pages[]" value="article"
                                   {{ in_array('article', old('target_pages', $campaign->target_pages ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Articles</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_pages[]" value="category"
                                   {{ in_array('category', old('target_pages', $campaign->target_pages ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Catégories</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_pages[]" value="rubrique"
                                   {{ in_array('rubrique', old('target_pages', $campaign->target_pages ?? [])) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Rubriques</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <button type="button" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?')) { document.getElementById('delete-form').submit(); }"
                    class="px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50">
                Supprimer
            </button>

            <div class="flex gap-3">
                <a href="{{ route('advertiser.campaigns.show', $campaign) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>

    <!-- Formulaire de suppression caché -->
    <form id="delete-form" action="{{ route('advertiser.campaigns.destroy', $campaign) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</div>

@push('scripts')
<script>
// Gestion du type de contenu
document.querySelectorAll('input[name="content_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('content-image').style.display = 'none';
        document.getElementById('content-video').style.display = 'none';

        document.getElementById('content-' + this.value).style.display = 'block';
    });
});

// Gestion du type de vidéo
document.querySelectorAll('input[name="video_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const urlInput = document.getElementById('video-url-input');
        const fileInput = document.getElementById('video-file-input');

        if (this.value === 'url') {
            urlInput.style.display = 'block';
            fileInput.style.display = 'none';
            fileInput.querySelector('input').value = '';
        } else {
            urlInput.style.display = 'none';
            fileInput.style.display = 'block';
            urlInput.querySelector('input').value = '';
        }
    });
});

// Initialiser l'affichage au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Afficher la section selon le type de contenu
    const checkedContentType = document.querySelector('input[name="content_type"]:checked');
    if(checkedContentType) {
        checkedContentType.dispatchEvent(new Event('change'));
    }

    // Afficher le bon input vidéo
    const checkedVideoType = document.querySelector('input[name="video_type"]:checked');
    if(checkedVideoType) {
        checkedVideoType.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
