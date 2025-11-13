{{-- resources/views/membership/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Devenir Membre LCM+ - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- En-tête -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-black text-blue-900 mb-4">
                DEVENIR MEMBRE DE LIGNE CLAIRE MÉDIA+
            </h1>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Rejoignez notre communauté et participez activement au développement d'une information libre et indépendante.
            </p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form action="{{ route('membership.store') }}" method="POST" id="membershipForm">
                @csrf

                <!-- Type de membre -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Type de membre *</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="type_membre" value="individuel" required class="mr-3" onchange="toggleFields()">
                            <div>
                                <div class="font-bold text-gray-800">Personne Physique</div>
                                <div class="text-xs text-gray-600">Individuel</div>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="type_membre" value="association" required class="mr-3" onchange="toggleFields()">
                            <div>
                                <div class="font-bold text-gray-800">Association</div>
                                <div class="text-xs text-gray-600">Organisation</div>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="type_membre" value="entreprise" required class="mr-3" onchange="toggleFields()">
                            <div>
                                <div class="font-bold text-gray-800">Entreprise</div>
                                <div class="text-xs text-gray-600">Société</div>
                            </div>
                        </label>
                    </div>
                    @error('type_membre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Personne Physique -->
                <div id="individuel-fields" class="hidden">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informations Personnelles</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Civilité *</label>
                            <select name="civilite" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('civilite') border-red-500 @enderror">
                                <option value="">Sélectionner</option>
                                <option value="M." {{ old('civilite') === 'M.' ? 'selected' : '' }}>M.</option>
                                <option value="Mme" {{ old('civilite') === 'Mme' ? 'selected' : '' }}>Mme</option>
                                <option value="Mlle" {{ old('civilite') === 'Mlle' ? 'selected' : '' }}>Mlle</option>
                            </select>
                            @error('civilite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('prenom') border-red-500 @enderror">
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance *</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('date_naissance') border-red-500 @enderror">
                            @error('date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lieu de naissance *</label>
                            <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('lieu_naissance') border-red-500 @enderror">
                            @error('lieu_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Association -->
                <div id="association-fields" class="hidden">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informations de l'Association</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'association *</label>
                        <input type="text" name="nom_association" value="{{ old('nom_association') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nom_association') border-red-500 @enderror">
                        @error('nom_association')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du représentant *</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section Entreprise -->
                <div id="entreprise-fields" class="hidden">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informations de l'Entreprise</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise *</label>
                        <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nom_entreprise') border-red-500 @enderror">
                        @error('nom_entreprise')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du représentant *</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informations communes -->
                <div class="mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informations de Contact</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nationalité *</label>
                            <input type="text" name="nationalite" value="{{ old('nationalite') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nationalite') border-red-500 @enderror">
                            @error('nationalite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profession *</label>
                            <input type="text" name="profession" value="{{ old('profession') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('profession') border-red-500 @enderror">
                            @error('profession')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adresse postale *</label>
                        <textarea name="adresse_postale" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('adresse_postale') border-red-500 @enderror">{{ old('adresse_postale') }}</textarea>
                        @error('adresse_postale')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input type="tel" name="telephone" value="{{ old('telephone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('telephone') border-red-500 @enderror">
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Cotisation -->
                <div class="mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Cotisation Annuelle</h3>

                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-gray-700">
                                <strong>Montant minimum :</strong> 1 000 FCFA pour les personnes physiques
                                <br>
                                <strong>Montant suggéré :</strong> 5 000 FCFA ou plus pour les associations et entreprises
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant de la cotisation (FCFA) *</label>
                        <input type="number" name="montant" value="{{ old('montant', 1000) }}" min="1000" step="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('montant') border-red-500 @enderror">
                        @error('montant')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mode de paiement *</label>
                        <select name="mode_paiement" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mode_paiement') border-red-500 @enderror">
                            <option value="">Sélectionner</option>
                            <option value="mobile_money" {{ old('mode_paiement') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="virement" {{ old('mode_paiement') === 'virement' ? 'selected' : '' }}>Virement bancaire</option>
                            <option value="especes" {{ old('mode_paiement') === 'especes' ? 'selected' : '' }}>Espèces</option>
                        </select>
                        @error('mode_paiement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Acceptation -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <label class="flex items-start">
                        <input type="checkbox" required class="mt-1 mr-3" id="acceptTerms">
                        <span class="text-sm text-gray-700">
                            Je certifie l'exactitude des informations fournies et j'accepte les statuts de l'association LIGNE CLAIRE MÉDIA+.
                            Je m'engage à respecter les règles et principes de l'organisation.
                        </span>
                    </label>
                </div>

                <!-- Boutons -->
                <div class="mt-8 flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg">
                        Valider ma demande d'adhésion
                    </button>
                    <a href="{{ route('home') }}" class="px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Informations complémentaires -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pourquoi devenir membre ?</h3>
            <ul class="space-y-3 text-gray-700">
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Participer à la gouvernance démocratique du média</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Accès privilégié aux contenus et événements exclusifs</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Contribuer à une information libre et indépendante</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Rejoindre une communauté engagée pour la transparence</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFields() {
        const type = document.querySelector('input[name="type_membre"]:checked')?.value;

        ['individuel', 'association', 'entreprise'].forEach(t => {
            const section = document.getElementById(`${t}-fields`);
            const inputs = section.querySelectorAll('input, select, textarea');
            section.classList.add('hidden');
            inputs.forEach(i => i.disabled = true);
        });

        const active = document.getElementById(`${type}-fields`);
        if (active) {
            active.classList.remove('hidden');
            active.querySelectorAll('input, select, textarea').forEach(i => i.disabled = false);
        }
    }

    // Gestion de l'affichage des champs selon le type
    // function toggleFields() {
    //     const type = document.querySelector('input[name="type_membre"]:checked')?.value;

    //     document.getElementById('individuel-fields').classList.add('hidden');
    //     document.getElementById('association-fields').classList.add('hidden');
    //     document.getElementById('entreprise-fields').classList.add('hidden');

    //     if (type === 'individuel') {
    //         document.getElementById('individuel-fields').classList.remove('hidden');
    //     } else if (type === 'association') {
    //         document.getElementById('association-fields').classList.remove('hidden');
    //     } else if (type === 'entreprise') {
    //         document.getElementById('entreprise-fields').classList.remove('hidden');
    //     }
    // }

    // Validation du formulaire
    document.getElementById('membershipForm').addEventListener('submit', function(e) {
        if (!document.getElementById('acceptTerms').checked) {
            e.preventDefault();
            alert('Veuillez accepter les conditions avant de soumettre.');
            return false;
        }
    });
</script>
@endpush
@endsection
