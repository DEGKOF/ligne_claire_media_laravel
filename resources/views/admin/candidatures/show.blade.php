@extends('layouts.admin')

@section('page-title', 'Détails de la candidature #' . $candidature->id)

@section('content')
<div class="space-y-6">

    <!-- Bouton retour -->
    <div>
        <a href="{{ route('admin.candidatures.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Informations du candidat -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center font-bold text-white text-2xl shadow-lg">
                            {{ substr($candidature->prenom, 0, 1) }}{{ substr($candidature->nom, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $candidature->nom_complet }}</h2>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $candidature->poste === 'journaliste' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $candidature->poste_libelle }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $candidature->statut_couleur }}">
                                    {{ $candidature->statut_libelle }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $candidature->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Téléphone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $candidature->telephone }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Date de candidature</p>
                            <p class="text-sm font-medium text-gray-900">{{ $candidature->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    @if($candidature->date_examen)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Date d'examen</p>
                            <p class="text-sm font-medium text-gray-900">{{ $candidature->date_examen->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Documents</h3>

                <div class="space-y-3">
                    <!-- CV -->
                    <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Curriculum Vitae</p>
                                <p class="text-xs text-gray-600">Document PDF ou DOC</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.candidatures.download-cv', $candidature) }}"
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Télécharger
                        </a>
                    </div>

                    <!-- Lettre de motivation -->
                    @if($candidature->hasLettreTexte())
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Lettre de motivation</p>
                                        <p class="text-xs text-gray-600">Texte écrit directement</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded border border-green-300 max-h-64 overflow-y-auto">
                                <p class="text-sm text-gray-800 whitespace-pre-line leading-relaxed">{{ $candidature->lettre_motivation_texte }}</p>
                            </div>
                        </div>
                    @elseif($candidature->hasLettreFichier())
                        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Lettre de motivation</p>
                                    <p class="text-xs text-gray-600">Fichier uploadé</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.candidatures.download-lettre', $candidature) }}"
                               class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Télécharger
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes admin -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Notes internes</h3>

                <form action="{{ route('admin.candidatures.update-notes', $candidature) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <textarea name="notes_admin"
                              rows="6"
                              placeholder="Ajoutez vos notes sur cette candidature..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $candidature->notes_admin }}</textarea>

                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Enregistrer les notes
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Colonne latérale -->
        <div class="space-y-6">

            <!-- Changer le statut -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statut de la candidature</h3>

                <form action="{{ route('admin.candidatures.update-status', $candidature) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-3">
                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $candidature->statut === 'en_attente' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300' }}">
                            <input type="radio"
                                   name="statut"
                                   value="en_attente"
                                   {{ $candidature->statut === 'en_attente' ? 'checked' : '' }}
                                   class="mr-3">
                            <div>
                                <p class="font-medium text-gray-900">En attente</p>
                                <p class="text-xs text-gray-500">Non encore examinée</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $candidature->statut === 'examinee' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}">
                            <input type="radio"
                                   name="statut"
                                   value="examinee"
                                   {{ $candidature->statut === 'examinee' ? 'checked' : '' }}
                                   class="mr-3">
                            <div>
                                <p class="font-medium text-gray-900">Examinée</p>
                                <p class="text-xs text-gray-500">Candidature étudiée</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $candidature->statut === 'acceptee' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                            <input type="radio"
                                   name="statut"
                                   value="acceptee"
                                   {{ $candidature->statut === 'acceptee' ? 'checked' : '' }}
                                   class="mr-3">
                            <div>
                                <p class="font-medium text-gray-900">Acceptée</p>
                                <p class="text-xs text-gray-500">Candidat retenu</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $candidature->statut === 'refusee' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300' }}">
                            <input type="radio"
                                   name="statut"
                                   value="refusee"
                                   {{ $candidature->statut === 'refusee' ? 'checked' : '' }}
                                   class="mr-3">
                            <div>
                                <p class="font-medium text-gray-900">Refusée</p>
                                <p class="text-xs text-gray-500">Candidature rejetée</p>
                            </div>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full mt-4 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                        Mettre à jour le statut
                    </button>
                </form>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions rapides</h3>

                <div class="space-y-2">
                    <a href="mailto:{{ $candidature->email }}"
                       class="flex items-center gap-2 w-full bg-blue-100 text-blue-700 px-4 py-3 rounded-lg hover:bg-blue-200 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Envoyer un email
                    </a>

                    <a href="tel:{{ $candidature->telephone }}"
                       class="flex items-center gap-2 w-full bg-green-100 text-green-700 px-4 py-3 rounded-lg hover:bg-green-200 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Appeler
                    </a>
                </div>
            </div>

            <!-- Zone danger -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-2 border-red-200">
                <h3 class="text-lg font-bold text-red-600 mb-4">Zone de danger</h3>

                <p class="text-sm text-gray-600 mb-4">
                    La suppression de cette candidature est irréversible. Tous les fichiers associés seront également supprimés.
                </p>

                <form action="{{ route('admin.candidatures.destroy', $candidature) }}"
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition font-medium">
                        Supprimer la candidature
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
