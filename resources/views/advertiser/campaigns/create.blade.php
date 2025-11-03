@extends('layouts.admin')

@section('title', 'Créer une campagne')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer une campagne publicitaire</h1>
        <p class="text-gray-600 mt-2">Remplissez les informations pour créer votre campagne</p>
    </div>

    <form action="{{ route('advertiser.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Informations générales -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations générales</h2>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la campagne *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Ex: Promotion Rentrée 2025"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emplacement publicitaire *</label>
                    <select name="placement_id" required id="placement-select"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner un emplacement...</option>
                        @foreach($placements as $placement)
                            <option value="{{ $placement->id }}"
                                    data-price="{{ $placement->price_format }}"
                                    data-dimensions="{{ $placement->dimensions }}"
                                    {{ old('placement_id') == $placement->id ? 'selected' : '' }}>
                                {{ $placement->name }} - {{ $placement->price_format }}
                            </option>
                        @endforeach
                    </select>
                    <div id="placement-info" class="mt-2 text-sm text-gray-600"></div>
                    @error('placement_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contenu publicitaire -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Contenu publicitaire</h2>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de contenu *</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500">
                            <input type="radio" name="content_type" value="image" checked class="mr-3">
                            <span class="text-sm font-medium">Image</span>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500">
                            <input type="radio" name="content_type" value="video" class="mr-3">
                            <span class="text-sm font-medium">Vidéo</span>
                        </label>
                    </div>
                </div>

                <div id="content-image">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image publicitaire *</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG, GIF (max 2MB)</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="content-video" style="display:none;">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Choisir le type de vidéo</label>
                            <div class="flex gap-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="video_type" value="url" checked class="mr-2">
                                    <span class="text-sm">Lien YouTube/Vimeo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="video_type" value="file" class="mr-2">
                                    <span class="text-sm">Fichier vidéo</span>
                                </label>
                            </div>
                        </div>

                        <div id="video-url-input">
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo</label>
                            <input type="url" name="video_url" value="{{ old('video_url') }}"
                                placeholder="https://www.youtube.com/watch?v=..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">YouTube, Vimeo, etc.</p>
                        </div>

                        <div id="video-file-input" style="display:none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fichier vidéo</label>
                            <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Formats : MP4, WebM (max 50MB)</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre (headline)</label>
                        <input type="text" name="headline" value="{{ old('headline') }}"
                               placeholder="Titre accrocheur"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Texte du bouton (CTA)</label>
                        <input type="text" name="cta_text" value="{{ old('cta_text') }}"
                               placeholder="En savoir plus, Acheter maintenant..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description courte</label>
                        <textarea name="caption" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('caption') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL de destination *</label>
                        <input type="url" name="target_url" value="{{ old('target_url') }}" required
                               placeholder="https://www.votre-site.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('target_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="open_new_tab" value="1" checked class="mr-2">
                            <span class="text-sm text-gray-700">Ouvrir dans un nouvel onglet</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Période et budget -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Période et budget</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Budget total (FCFA)</label>
                    <input type="number" name="budget" value="{{ old('budget') }}" min="0" step="100"
                           placeholder="50000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour illimité</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Budget journalier (FCFA)</label>
                    <input type="number" name="daily_budget" value="{{ old('daily_budget') }}" min="0" step="100"
                           placeholder="2000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Ciblage (optionnel) -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ciblage <span class="text-sm font-normal text-gray-500">(optionnel)</span></h2>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appareils</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="target_devices[]" value="desktop" class="mr-2">
                            <span class="text-sm">Desktop</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_devices[]" value="mobile" class="mr-2">
                            <span class="text-sm">Mobile</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour tous les appareils</p>
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('advertiser.campaigns.index') }}"
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Créer la campagne
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
// Afficher les infos de l'emplacement sélectionné
document.getElementById('placement-select').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const infoDiv = document.getElementById('placement-info');

    if (option.value) {
        const price = option.getAttribute('data-price');
        const dimensions = option.getAttribute('data-dimensions');
        infoDiv.innerHTML = `<strong>Tarif :</strong> ${price} | <strong>Dimensions :</strong> ${dimensions}`;
    } else {
        infoDiv.innerHTML = '';
    }
});

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
</script>
@endpush
@endsection
