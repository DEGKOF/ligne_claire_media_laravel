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

    <!-- En-tête explicatif -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-lg mb-8 border border-blue-200">
        <div class="flex items-start gap-3 mb-3">
            <svg class="w-8 h-8 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Rejoignez LCM Press</h2>
                <p class="text-gray-700 mb-2">
                    En devenant membre, vous financez directement un journalisme utile, rigoureux et sans pression extérieure.
                </p>
                <p class="text-sm text-gray-600">
                    <strong>100% indépendant</strong> • Sans subvention • Sans publicité politique • Sans influence privée
                </p>
            </div>
        </div>
    </div>

    <!-- Choix de la formule -->
    <div class="mb-8">
        <label class="block text-lg font-bold text-gray-800 mb-4">Choisissez votre formule d'engagement *</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Formule Citoyen -->
            <label style="border: 1px solid black" class="relative flex flex-col p-6 border-3 border-gray-300 rounded-xl cursor-pointer hover:border-blue-500 hover:shadow-lg transition-all group">
                <input type="radio" name="formule" value="citoyen" required class="absolute top-4 right-4 w-5 h-5" checked>
                <div class="mb-3">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full mb-2">
                        RECOMMANDÉ
                    </span>
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="text-xl font-bold text-gray-800">Membre Citoyen</div>
                    </div>
                    <div class="text-3xl font-black text-blue-600 mt-2">5 000 FCFA<span class="text-lg font-normal text-gray-600">/mois</span></div>
                    <div class="text-sm text-gray-500 mt-1">"Soutenir l'essentiel"</div>
                </div>
                <ul class="space-y-2 text-sm text-gray-700 mt-3">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Accès complet aux articles et contenus exclusifs</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Droit de regard sur la ligne éditoriale via le Conseil Citoyen</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Participation aux assemblées consultatives</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Invitation aux événements privés (tables rondes, conférences)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Droit de vote après 3 ans</strong> de soutien récurrent</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Carte de membre + Newsletter LCM Communauté</span>
                    </li>
                </ul>
            </label>

            <!-- Formule Ambassadeur -->
            <label style="border: 1px solid black" class="relative flex flex-col p-6 border-3 border-gray-300 rounded-xl cursor-pointer hover:border-yellow-500 hover:shadow-lg transition-all group">
                <input type="radio" name="formule" value="ambassadeur" required class="absolute top-4 right-4 w-5 h-5">
                <div class="mb-3">
                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full mb-2">
                        ENGAGEMENT +
                    </span>
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <div class="text-xl font-bold text-gray-800">Membre Ambassadeur</div>
                    </div>
                    <div class="text-3xl font-black text-yellow-600 mt-2">10 000 FCFA<span class="text-lg font-normal text-gray-600">/mois</span></div>
                    <div class="text-sm text-gray-500 mt-1">"S'engager pour l'indépendance"</div>
                </div>
                <ul class="space-y-2 text-sm text-gray-700 mt-3">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Tous les avantages Membre Citoyen, plus :</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Accès anticipé aux enquêtes LCM Investigation</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Accès aux rapports de transparence et bilans financiers</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Badge "Ambassadeur LCM" (profil public facultatif)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Possibilité de devenir sociétaire</strong></span>
                    </li>
                </ul>
            </label>
        </div>
        @error('formule')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Informations personnelles -->
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4 border-b-2 border-gray-200 pb-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Vos informations personnelles</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror"
                    placeholder="Votre nom de famille">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror"
                    placeholder="Votre prénom">
                @error('prenom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="votre@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de téléphone (WhatsApp) *</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror"
                    placeholder="+229 XX XX XX XX">
                @error('telephone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Mode de paiement -->
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4 border-b-2 border-gray-200 pb-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Mode de paiement</h3>
        </div>

        <label class="block text-sm font-medium text-gray-700 mb-3">Mode de paiement préféré *</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="mode_paiement" value="mobile_money" required class="mr-3" checked>
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <div class="font-bold text-gray-800">Mobile Money</div>
                        <div class="text-xs text-gray-600">MTN, Moov, etc.</div>
                    </div>
                </div>
            </label>
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="mode_paiement" value="carte_bancaire" required class="mr-3">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <div>
                        <div class="font-bold text-gray-800">Carte bancaire</div>
                        <div class="text-xs text-gray-600">Visa, Mastercard</div>
                    </div>
                </div>
            </label>
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="mode_paiement" value="crypto" required class="mr-3">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <div class="font-bold text-gray-800">Crypto</div>
                        <div class="text-xs text-gray-600">Bitcoin, USDT</div>
                    </div>
                </div>
            </label>
        </div>
        @error('mode_paiement')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Fréquence de paiement -->
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4 border-b-2 border-gray-200 pb-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Fréquence de paiement</h3>
        </div>

        <label class="block text-sm font-medium text-gray-700 mb-3">Choisissez votre fréquence *</label>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <label class="relative flex flex-col p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="frequence" value="mensuel" required class="absolute top-3 right-3" checked>
                <div class="font-bold text-gray-800 mb-1">Mensuel</div>
                <div class="text-sm text-gray-600">Paiement chaque mois</div>
            </label>
            <label class="relative flex flex-col p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="frequence" value="trimestriel" required class="absolute top-3 right-3">
                <div class="font-bold text-gray-800 mb-1">Trimestriel</div>
                <div class="text-sm text-gray-600">Tous les 3 mois</div>
            </label>
            <label class="relative flex flex-col p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                <input type="radio" name="frequence" value="semestriel" required class="absolute top-3 right-3">
                <div class="font-bold text-gray-800 mb-1">Semestriel</div>
                <div class="text-sm text-gray-600">Tous les 6 mois</div>
            </label>
            <label class="relative flex flex-col p-4 border-2 border-yellow-400 bg-yellow-50 rounded-lg cursor-pointer hover:border-yellow-500 transition">
                <input type="radio" name="frequence" value="annuel" required class="absolute top-3 right-3">
                <span class="inline-block px-2 py-0.5 bg-yellow-400 text-yellow-900 text-xs font-bold rounded mb-2 w-fit">
                    2 MOIS OFFERTS
                </span>
                <div class="font-bold text-gray-800 mb-1">Annuel</div>
                <div class="text-sm text-gray-600">Meilleure offre !</div>
            </label>
        </div>
        @error('frequence')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Visibilité publique -->
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4 border-b-2 border-gray-200 pb-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Visibilité</h3>
        </div>

        <div class="bg-gray-50 p-5 rounded-lg">
            <label class="flex items-start cursor-pointer">
                <input type="checkbox" name="apparaitre_publiquement" value="1" class="mt-1 mr-4 w-5 h-5 text-blue-600">
                <div>
                    <div class="font-medium text-gray-800 mb-1">
                        Souhaitez-vous apparaître publiquement parmi les soutiens ?
                    </div>
                    <div class="text-sm text-gray-600">
                        Si vous cochez cette case, votre nom apparaîtra sur la page "Nos soutiens citoyens" du site LCM+.
                        Sinon, votre contribution restera anonyme.
                    </div>
                </div>
            </label>
        </div>
        @error('apparaitre_publiquement')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Acceptation de la charte -->
    <div class="mb-8 bg-blue-50 border-2 border-blue-200 p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Validation</h3>
        </div>

        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="charte_acceptee" required class="mt-1 mr-4 w-5 h-5 text-blue-600" id="acceptCharte">
            <span class="text-sm text-gray-800">
                <svg class="w-4 h-4 inline-block text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                J'adhère à la <strong>Charte du membre citoyen LCM+</strong> et je comprends que ma contribution soutient un média
                indépendant, sans contrepartie financière ni droit de propriété.
            </span>
        </label>
        @error('charte_acceptee')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Sécurité et transparence -->
    <div class="mb-8 bg-gray-50 p-5 rounded-lg border border-gray-200">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <div class="text-sm text-gray-700">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <div class="font-bold text-gray-800">Sécurité & transparence</div>
                </div>
                <ul class="space-y-1 ml-7">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Paiement 100% sécurisé via Paystack / CinetPay / Stripe</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Reçu automatique envoyé par e-mail après chaque versement</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Rapport financier publié tous les 6 mois</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Vos données personnelles sont strictement confidentielles</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="flex flex-col md:flex-row gap-4">
        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg flex items-center justify-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Rejoindre LCM Press
        </button>
        <a href="{{ route('home') }}" class="px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-lg font-bold text-center hover:bg-gray-50 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
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
{{-- <script>
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
</script> --}}


<script>
// Script pour mettre à jour dynamiquement l'affichage du montant selon la formule choisie
document.querySelectorAll('input[name="formule"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Vous pouvez ajouter ici une logique pour afficher le montant calculé
        // selon la fréquence et la formule choisies
    });
});

// Validation côté client
document.getElementById('membershipForm').addEventListener('submit', function(e) {
    const charteAcceptee = document.getElementById('acceptCharte');
    if (!charteAcceptee.checked) {
        e.preventDefault();
        alert('Vous devez accepter la Charte du membre citoyen LCM+ pour continuer.');
        charteAcceptee.focus();
    }
});
</script>
@endpush
@endsection
