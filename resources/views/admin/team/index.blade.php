@extends('layouts.admin')

@section('page-title', 'Gestion de l\'équipe')

@section('content')
<div class="space-y-6">
    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notre équipe</h2>
            <p class="text-gray-600 mt-1">Gérez les membres affichés sur la page publique</p>
        </div>
        <a href="{{ route('admin.team.create') }}"
            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-plus"></i>
            Ajouter un membre
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" placeholder="Rechercher un membre..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

            <select name="visibility"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les statuts</option>
                <option value="visible" {{ request('visibility') === 'visible' ? 'selected' : '' }}>Visibles</option>
                <option value="hidden" {{ request('visibility') === 'hidden' ? 'selected' : '' }}>Masqués</option>
            </select>

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Filtrer
            </button>

            @if(request('search') || request('visibility'))
                <a href="{{ route('admin.team.index') }}"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Liste des membres -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Membre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Poste
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ordre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ $member->photo_url }}" alt="{{ $member->full_name }}"
                                            class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($member->prenom, 0, 1) . substr($member->nom, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $member->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $member->poste }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">
                                    @if($member->telephone)
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas fa-phone text-gray-400"></i>
                                            {{ $member->telephone }}
                                        </div>
                                    @endif
                                    @if($member->email)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                            {{ $member->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $member->ordre }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->is_visible)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i> Visible
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-eye-slash mr-1"></i> Masqué
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Toggle visibilité -->
                                    <form method="POST" action="{{ route('admin.team.toggle', $member) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-{{ $member->is_visible ? 'orange' : 'green' }}-600 hover:text-{{ $member->is_visible ? 'orange' : 'green' }}-900"
                                            title="{{ $member->is_visible ? 'Masquer' : 'Afficher' }}">
                                            <i class="fas fa-{{ $member->is_visible ? 'eye-slash' : 'eye' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <!-- Modifier -->
                                    <a href="{{ route('admin.team.edit', $member) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Modifier">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>

                                    <!-- Supprimer -->
                                    <form method="POST" action="{{ route('admin.team.destroy', $member) }}"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                                <p class="text-lg">Aucun membre trouvé</p>
                                <a href="{{ route('admin.team.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                    Ajouter le premier membre
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
