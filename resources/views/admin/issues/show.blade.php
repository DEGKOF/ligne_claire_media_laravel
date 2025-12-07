@extends('layouts.admin')

@section('title', 'Aperçu du journal')

@section('page-title', 'Aperçu du journal #' . $issue->issue_number)

@section('content')
<div class="mb-6">
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.issues.edit', $issue) }}"
           class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-edit"></i>
            <span>Modifier</span>
        </a>
        <a href="{{ route('admin.issues.index') }}"
           class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Carte principale -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Image de couverture -->
                <div class="md:col-span-1">
                    @if($issue->cover_image)
                        <img src="{{ asset('storage/'.$issue->cover_image) }}"
                             alt="{{ $issue->title }}"
                             class="w-full rounded-lg shadow-md">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-100 rounded-lg flex flex-col items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 text-sm">Aucune couverture</p>
                        </div>
                    @endif
                </div>

                <!-- Informations -->
                <div class="md:col-span-2">
                    <div class="flex gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            N° {{ $issue->issue_number }}
                        </span>
                        @if($issue->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Publié
                            </span>
                        @elseif($issue->status === 'draft')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Brouillon
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Archivé
                            </span>
                        @endif
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $issue->title }}</h2>

                    @if($issue->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $issue->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Date de publication</h3>
                            <p class="flex items-center gap-2 text-gray-900">
                                <i class="fas fa-calendar text-blue-600"></i>
                                <span>{{ $issue->published_at->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Stock disponible</h3>
                            <p class="flex items-center gap-2 text-gray-900">
                                @if($issue->isInStock())
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span>{{ $issue->stock_quantity }} exemplaires</span>
                                @else
                                    <i class="fas fa-times-circle text-red-600"></i>
                                    <span>Épuisé</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Prix version papier</h3>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($issue->price, 2) }} FCFA</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Prix version digitale</h3>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($issue->digital_price, 2) }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fichier PDF -->
        @if($issue->pdf_file)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-red-600 px-6 py-3 flex items-center gap-2">
                <i class="fas fa-file-pdf text-white"></i>
                <h3 class="text-lg font-semibold text-white">Fichier PDF</h3>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900 mb-1">Journal numérique disponible</p>
                        <p class="text-sm text-gray-600">
                            Ce fichier sera accessible aux utilisateurs après achat
                        </p>
                    </div>
                    <a href="{{ asset('storage/' . $issue->pdf_file) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-download"></i>
                        <span>Télécharger</span>
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <i class="fas fa-file-pdf text-5xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun fichier PDF disponible</p>
            <a href="{{ route('admin.issues.edit', $issue) }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-upload"></i>
                <span>Ajouter un PDF</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
            <div class="space-y-3">
                @if($issue->status === 'draft')
                    <form action="{{ route('admin.issues.update-status', $issue) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Publier le journal</span>
                        </button>
                    </form>
                @elseif($issue->status === 'published')
                    <form action="{{ route('admin.issues.update-status', $issue) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="archived">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-archive"></i>
                            <span>Archiver</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.issues.update-status', $issue) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Republier</span>
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.issues.edit', $issue) }}"
                   class="block w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-center">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-gray-600 block mb-1">Créé le</span>
                    <p class="font-medium text-gray-900">{{ $issue->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 block mb-1">Dernière modification</span>
                    <p class="font-medium text-gray-900">{{ $issue->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($issue->deleted_at)
                <div>
                    <span class="text-gray-600 block mb-1">Supprimé le</span>
                    <p class="font-medium text-red-600">{{ $issue->deleted_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Ventes papier</span>
                    <p class="text-lg font-semibold text-gray-900">0 exemplaires</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Ventes digitales</span>
                    <p class="text-lg font-semibold text-gray-900">0 téléchargements</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600 flex items-start gap-2">
                    <i class="fas fa-info-circle mt-0.5"></i>
                    <span>Les statistiques seront disponibles après les premières ventes</span>
                </p>
            </div>
        </div>

        <!-- Zone dangereuse -->
        <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
            <div class="bg-red-600 px-6 py-3">
                <h3 class="text-lg font-semibold text-white">Zone dangereuse</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    La suppression archivera ce journal. Vous pourrez le restaurer ultérieurement.
                </p>
                <form action="{{ route('admin.issues.destroy', $issue) }}"
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir archiver ce journal ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Supprimer le journal</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
