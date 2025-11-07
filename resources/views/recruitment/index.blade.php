@extends('layouts.frontend')

@section('title', 'Nous rejoindre — LIGNE CLAIRE MÉDIA+')

@section('meta_description', 'Rejoignez l\'équipe de LIGNE CLAIRE MÉDIA+. Postulez pour un poste de journaliste ou rédacteur et participez à notre aventure médiatique.')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                Rejoignez Notre Équipe
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                LIGNE CLAIRE MÉDIA+ recrute des talents passionnés par le journalisme et l'information.
                Envoyez-nous votre candidature et participez à notre mission d'informer avec rigueur et indépendance.
            </p>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-8 bg-green-50 border-l-4 border-green-500 p-6 rounded-lg shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-green-800 font-bold mb-1">Candidature envoyée avec succès !</h3>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-4xl mx-auto mb-8 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-bold mb-1">Erreur</h3>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Postes disponibles -->
        <div class="max-w-4xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Postes Disponibles</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Journaliste -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-blue-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Journaliste</h3>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Recherche, investigation, rédaction d'articles, interviews et couverture d'événements.
                        Expérience en journalisme requise.
                    </p>
                </div>

                <!-- Rédacteur -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Rédacteur</h3>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Rédaction de contenus web, révision, adaptation d'articles et production de contenus éditoriaux de qualité.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulaire de candidature -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Postuler Maintenant</h2>

            <form action="{{ route('recruitment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Informations personnelles -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="nom"
                               name="nom"
                               value="{{ old('nom') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="prenom"
                               name="prenom"
                               value="{{ old('prenom') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('prenom') border-red-500 @enderror">
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel"
                               id="telephone"
                               name="telephone"
                               value="{{ old('telephone') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('telephone') border-red-500 @enderror">
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Poste -->
                <div>
                    <label for="poste" class="block text-sm font-semibold text-gray-700 mb-2">
                        Poste souhaité <span class="text-red-500">*</span>
                    </label>
                    <select id="poste"
                            name="poste"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('poste') border-red-500 @enderror">
                        <option value="">-- Sélectionnez un poste --</option>
                        <option value="journaliste" {{ old('poste') === 'journaliste' ? 'selected' : '' }}>Journaliste</option>
                        <option value="redacteur" {{ old('poste') === 'redacteur' ? 'selected' : '' }}>Rédacteur</option>
                    </select>
                    @error('poste')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CV -->
                <div>
                    <label for="cv" class="block text-sm font-semibold text-gray-700 mb-2">
                        CV <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file"
                               id="cv"
                               name="cv"
                               accept=".pdf,.doc,.docx"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('cv') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Formats acceptés : PDF, DOC, DOCX (Max: 5 Mo)</p>
                    @error('cv')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lettre de motivation -->
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Lettre de motivation <span class="text-red-500">*</span>
                    </label>
                    <p class="text-sm text-gray-600 mb-4">Vous pouvez soit écrire votre lettre directement, soit uploader un fichier.</p>

                    <!-- Toggle entre texte et fichier -->
                    <div class="flex gap-4 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio"
                                   name="lettre_type"
                                   value="texte"
                                   checked
                                   class="mr-2"
                                   onchange="toggleLettreMotivation('texte')">
                            <span class="text-sm font-medium text-gray-700">Écrire ma lettre</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio"
                                   name="lettre_type"
                                   value="fichier"
                                   class="mr-2"
                                   onchange="toggleLettreMotivation('fichier')">
                            <span class="text-sm font-medium text-gray-700">Uploader un fichier</span>
                        </label>
                    </div>

                    <!-- Zone de texte -->
                    <div id="lettre-texte-container">
                        <textarea id="lettre_motivation_texte"
                                  name="lettre_motivation_texte"
                                  rows="8"
                                  placeholder="Écrivez votre lettre de motivation ici..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lettre_motivation_texte') border-red-500 @enderror">{{ old('lettre_motivation_texte') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Maximum 5000 caractères</p>
                        @error('lettre_motivation_texte')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Zone d'upload -->
                    <div id="lettre-fichier-container" class="hidden">
                        <input type="file"
                               id="lettre_motivation_fichier"
                               name="lettre_motivation_fichier"
                               accept=".pdf,.doc,.docx"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lettre_motivation_fichier') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Formats acceptés : PDF, DOC, DOCX (Max: 5 Mo)</p>
                        @error('lettre_motivation_fichier')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    @error('lettre_motivation')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton de soumission -->
                <div class="flex justify-center pt-6">
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-12 py-4 rounded-full font-bold text-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl">
                        Envoyer ma candidature
                    </button>
                </div>
            </form>
        </div>

        <!-- Section informations supplémentaires -->
        <div class="max-w-4xl mx-auto mt-12 grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg p-6 shadow-md text-center">
                <div class="text-4xl mb-3">⚡</div>
                <h3 class="font-bold text-gray-900 mb-2">Réponse rapide</h3>
                <p class="text-sm text-gray-600">Nous étudions votre candidature sous 7 jours ouvrés</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-md text-center">
                <div class="text-4xl mb-3">🔒</div>
                <h3 class="font-bold text-gray-900 mb-2">Confidentialité</h3>
                <p class="text-sm text-gray-600">Vos données sont traitées en toute confidentialité</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-md text-center">
                <div class="text-4xl mb-3">📧</div>
                <h3 class="font-bold text-gray-900 mb-2">Confirmation</h3>
                <p class="text-sm text-gray-600">Email de confirmation envoyé immédiatement</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleLettreMotivation(type) {
        const texteContainer = document.getElementById('lettre-texte-container');
        const fichierContainer = document.getElementById('lettre-fichier-container');
        const texteInput = document.getElementById('lettre_motivation_texte');
        const fichierInput = document.getElementById('lettre_motivation_fichier');

        if (type === 'texte') {
            texteContainer.classList.remove('hidden');
            fichierContainer.classList.add('hidden');
            fichierInput.value = ''; // Réinitialiser le fichier
        } else {
            texteContainer.classList.add('hidden');
            fichierContainer.classList.remove('hidden');
            texteInput.value = ''; // Réinitialiser le texte
        }
    }
</script>
@endpush
@endsection
