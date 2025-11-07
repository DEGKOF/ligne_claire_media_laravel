@extends('layouts.admin')

@section('title', 'Compléter mon profil')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">

    @if (isset($profileStatus) && $profileStatus != null)

                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    Statut du Profile: {{ $profileStatus }}
                </div>
    @endif
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Compléter mon profil annonceur</h1>
        <p class="text-gray-600 mt-2">Veuillez remplir toutes les informations pour validation</p>
    </div>

    <form action="{{ route('advertiser.profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Informations Entreprise -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations entreprise</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise *</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('company_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Forme juridique</label>
                    <select name="legal_form" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner...</option>
                        <option value="SARL" {{ old('legal_form', $profile->legal_form) == 'SARL' ? 'selected' : '' }}>SARL</option>
                        <option value="SA" {{ old('legal_form', $profile->legal_form) == 'SA' ? 'selected' : '' }}>SA</option>
                        <option value="EI" {{ old('legal_form', $profile->legal_form) == 'EI' ? 'selected' : '' }}>Entreprise Individuelle</option>
                        <option value="SNC" {{ old('legal_form', $profile->legal_form) == 'SNC' ? 'selected' : '' }}>SNC</option>
                        <option value="GIE" {{ old('legal_form', $profile->legal_form) == 'GIE' ? 'selected' : '' }}>GIE</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">RCCM</label>
                    <input type="text" name="rccm" value="{{ old('rccm', $profile->rccm) }}"
                           placeholder="RB/COT/2024/A/0001"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('rccm')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">IFU</label>
                    <input type="text" name="ifu" value="{{ old('ifu', $profile->ifu) }}"
                           placeholder="1234567890"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Secteur d'activité</label>
                    <input type="text" name="sector" value="{{ old('sector', $profile->sector) }}"
                           placeholder="Technologies, Commerce, Services..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre d'employés</label>
                    <input type="number" name="employees_count" value="{{ old('employees_count', $profile->employees_count) }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Année de création</label>
                    <input type="number" name="founded_year" value="{{ old('founded_year', $profile->founded_year) }}"
                           min="1800" max="{{ date('Y') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Coordonnées -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Coordonnées</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse complète *</label>
                    <textarea name="address" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address', $profile->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                    <input type="text" name="city" value="{{ old('city', $profile->city) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('city')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="tel" name="phone" value="{{ old('phone', $profile->phone) }}" required
                           placeholder="+229 XX XX XX XX"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                    <input type="url" name="website" value="{{ old('website', $profile->website) }}"
                           placeholder="https://www.exemple.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Contact Commercial -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact commercial</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name', $profile->contact_name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('contact_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Poste</label>
                    <input type="text" name="contact_position" value="{{ old('contact_position', $profile->contact_position) }}"
                           placeholder="Directeur Marketing, Responsable Communication..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="tel" name="contact_phone" value="{{ old('contact_phone', $profile->contact_phone) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('contact_phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $profile->contact_email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('contact_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Documents</h2>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo de l'entreprise</label>
                    <input type="file" name="logo" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format : JPG, PNG (max 2MB)</p>
                    @if($profile->logo)
                        <img src="{{ $profile->logo_url }}" alt="Logo actuel" class="mt-2 h-20">
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document d'entreprise</label>
                    <input type="file" name="company_document" accept=".pdf,image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Statuts, registre de commerce (PDF, JPG, PNG - max 5MB)</p>
                    @if($profile->company_document)
                        <p class="text-xs text-green-600 mt-1">✓ Document déjà uploadé</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pièce d'identité du responsable</label>
                    <input type="file" name="id_document" accept=".pdf,image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">CNI, Passeport (PDF, JPG, PNG - max 5MB)</p>
                    @if($profile->id_document)
                        <p class="text-xs text-green-600 mt-1">✓ Document déjà uploadé</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('advertiser.dashboard') }}"
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Enregistrer et soumettre
            </button>
        </div>
    </form>

</div>
@endsection
