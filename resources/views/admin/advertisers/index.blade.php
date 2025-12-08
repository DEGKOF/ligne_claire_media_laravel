@extends('layouts.admin')

@section('page-title', 'Gestion des annonceurs')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600">En attente</div>
        <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600">Actifs</div>
        <div class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600">Suspendus</div>
        <div class="text-3xl font-bold text-red-600 mt-2">{{ $stats['suspended'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600">Rejetés</div>
        <div class="text-3xl font-bold text-gray-600 mt-2">{{ $stats['rejected'] }}</div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher..."
               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">

        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
        </select>

        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Filtrer
        </button>
    </form>
</div>

<!-- Liste -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entreprise</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Secteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solde</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($profiles as $profile)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($profile->logo)
                                <img src="{{ $profile->logo_url }}" alt="" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 font-bold">{{ substr($profile->company_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-900">{{ $profile->company_name }}</div>
                                <div class="text-xs text-gray-500">{{ $profile->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div>{{ $profile->contact_name }}</div>
                        <div class="text-gray-500">{{ $profile->contact_phone }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $profile->sector ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">{{ number_format($profile->balance, 0, ',', ' ') }} F</td>
                    <td class="px-6 py-4">{!! $profile->status_badge !!}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.advertisers.show', $profile) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        Aucun annonceur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $profiles->links() }}
</div>

@endsection
