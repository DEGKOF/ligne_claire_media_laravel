@extends('layouts.admin')

@section('page-title', 'Détails du message')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- En-tête -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('admin.contacts.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-2 mb-4">
                        <i class="fas fa-arrow-left"></i>
                        Retour aux messages
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ $contact->sujet }}</h2>
                </div>

                <!-- Statut -->
                <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full {{ $contact->status_badge }}">
                    {{ $contact->status_label }}
                </span>
            </div>
        </div>

        <!-- Informations de l'expéditeur -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Expéditeur</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($contact->prenom, 0, 1) . substr($contact->nom, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $contact->full_name }}</p>
                            <a href="mailto:{{ $contact->email }}"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                {{ $contact->email }}
                            </a>
                            @if($contact->telephone)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-phone mr-1"></i>{{ $contact->telephone }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Informations</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-700">
                            <i class="fas fa-calendar-alt w-5"></i>
                            <span>Reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        @if($contact->read_at)
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="fas fa-eye w-5"></i>
                                <span>Lu le {{ $contact->read_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        @endif
                        @if($contact->ip_address)
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="fas fa-globe w-5"></i>
                                <span>IP : {{ $contact->ip_address }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Message</h3>
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Changer le statut -->
                <div class="flex flex-wrap gap-2">
                    <form method="POST" action="{{ route('admin.contacts.status', $contact) }}" class="inline">
                        @csrf
                        @if($contact->status !== 'nouveau')
                            <button type="submit" name="status" value="nouveau"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                                <i class="fas fa-inbox"></i>
                                Marquer comme nouveau
                            </button>
                        @endif

                        @if($contact->status !== 'lu')
                            <button type="submit" name="status" value="lu"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition inline-flex items-center gap-2">
                                <i class="fas fa-eye"></i>
                                Marquer comme lu
                            </button>
                        @endif

                        @if($contact->status !== 'traite')
                            <button type="submit" name="status" value="traite"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center gap-2">
                                <i class="fas fa-check"></i>
                                Marquer comme traité
                            </button>
                        @endif

                        @if($contact->status !== 'archive')
                            <button type="submit" name="status" value="archive"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center gap-2">
                                <i class="fas fa-archive"></i>
                                Archiver
                            </button>
                        @endif
                    </form>
                </div>

                <!-- Actions supplémentaires -->
                <div class="flex gap-2">
                    {{-- <!-- Répondre par email -->
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->sujet }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                        <i class="fas fa-reply"></i>
                        Répondre
                    </a> --}}

                    <!-- Supprimer -->
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition inline-flex items-center gap-2">
                            <i class="fas fa-trash"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
