@extends('layouts.admin')

@section('page-title', $profile->company_name)

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.advertisers.index') }}" class="text-blue-600 hover:text-blue-800">
        ← Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Informations entreprise -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Informations entreprise</h2>
                {!! $profile->status_badge !!}
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    @if($profile->logo)
                        <div class="col-span-2">
                            <img src="{{ $profile->logo_url }}" alt="Logo" class="h-20">
                        </div>
                    @endif

                    <div>
                        <div class="text-sm text-gray-600">Nom</div>
                        <div class="font-medium">{{ $profile->company_name }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Forme juridique</div>
                        <div class="font-medium">{{ $profile->legal_form ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">RCCM</div>
                        <div class="font-medium">{{ $profile->rccm ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">IFU</div>
                        <div class="font-medium">{{ $profile->ifu ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Secteur</div>
                        <div class="font-medium">{{ $profile->sector ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Effectif</div>
                        <div class="font-medium">{{ $profile->employees_count ?? '-' }} employés</div>
                    </div>

                    <div class="col-span-2">
                        <div class="text-sm text-gray-600">Adresse</div>
                        <div class="font-medium">{{ $profile->address }}</div>
                        <div class="text-sm text-gray-500">{{ $profile->city }}, {{ $profile->country }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Téléphone</div>
                        <div class="font-medium">{{ $profile->phone }}</div>
                    </div>

                    @if($profile->website)
                        <div>
                            <div class="text-sm text-gray-600">Site web</div>
                            <a href="{{ $profile->website }}" target="_blank" class="font-medium text-blue-600 hover:underline">
                                {{ $profile->website }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact commercial -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Contact commercial</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-gray-600">Nom</div>
                        <div class="font-medium">{{ $profile->contact_name }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Poste</div>
                        <div class="font-medium">{{ $profile->contact_position ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Téléphone</div>
                        <div class="font-medium">{{ $profile->contact_phone }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Email</div>
                        <div class="font-medium">{{ $profile->contact_email }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campagnes récentes -->
        @if($profile->advertisements->count() > 0)
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Campagnes récentes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campagne</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stats</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($profile->advertisements as $ad)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium">{{ $ad->name }}</div>
                                <div class="text-xs text-gray-500">{{ $ad->reference }}</div>
                            </td>
                            <td class="px-6 py-4">{!! $ad->status_badge !!}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ number_format($ad->impressions_count) }} vues
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>

    <!-- Colonne latérale -->
    <div class="space-y-6">

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Actions</h2>

            <div class="space-y-3">
                @if($profile->status === 'pending')
                    <form action="{{ route('admin.advertisers.approve', $profile) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            ✓ Approuver
                        </button>
                    </form>

                    <button onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        ✗ Rejeter
                    </button>
                @endif

                @if($profile->status === 'active')
                    <button onclick="document.getElementById('suspend-modal').classList.remove('hidden')"
                            class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Suspendre
                    </button>
                @endif

                @if($profile->status === 'suspended')
                    <form action="{{ route('admin.advertisers.reactivate', $profile) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Réactiver
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Statistiques</h2>

            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-600">Solde</div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($profile->balance, 0, ',', ' ') }} F</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Campagnes actives</div>
                    <div class="text-2xl font-bold">{{ $profile->advertisements()->active()->count() }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Total campagnes</div>
                    <div class="text-2xl font-bold">{{ $profile->advertisements->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        @if($profile->validated_at)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Validation</h2>

            <div class="text-sm">
                <div class="text-gray-600">Validé le</div>
                <div class="font-medium">{{ $profile->validated_at->format('d/m/Y à H:i') }}</div>

                @if($profile->validator)
                    <div class="text-gray-600 mt-2">Par</div>
                    <div class="font-medium">{{ $profile->validator->full_name }}</div>
                @endif

                @if($profile->rejection_reason)
                    <div class="text-gray-600 mt-2">Raison</div>
                    <div class="text-red-600">{{ $profile->rejection_reason }}</div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Modal Rejet -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Rejeter le profil</h3>
        <form action="{{ route('admin.advertisers.reject', $profile) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                <textarea name="reason" rows="4" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Rejeter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Suspension -->
<div id="suspend-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Suspendre le profil</h3>
        <form action="{{ route('admin.advertisers.suspend', $profile) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Raison de la suspension *</label>
                <textarea name="reason" rows="4" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('suspend-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                    Suspendre
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
