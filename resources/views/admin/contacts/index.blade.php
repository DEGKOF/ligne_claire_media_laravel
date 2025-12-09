@extends('layouts.admin')

@section('page-title', 'Messages de contact')

@section('content')
<div class="space-y-6">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Nouveaux</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['nouveau'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-inbox text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 m-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Lus</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['lu'] }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i class="fas fa-eye text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Traités</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['traite'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" placeholder="Rechercher..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les statuts</option>
                <option value="nouveau" {{ request('status') === 'nouveau' ? 'selected' : '' }}>Nouveaux</option>
                <option value="lu" {{ request('status') === 'lu' ? 'selected' : '' }}>Lus</option>
                <option value="traite" {{ request('status') === 'traite' ? 'selected' : '' }}>Traités</option>
                <option value="archive" {{ request('status') === 'archive' ? 'selected' : '' }}>Archivés</option>
            </select>

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Filtrer
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.contacts.index') }}"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto" style="min-height: 20vh !important; ">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Expéditeur
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sujet
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
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
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition {{ $contact->status === 'nouveau' ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}"
                                    class="contact-checkbox rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $contact->full_name }}
                                        </div>
                                        @if($contact->status === 'nouveau')
                                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                                    @if($contact->telephone)
                                        <div class="text-sm text-gray-500">{{ $contact->telephone }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">{{ Str::limit($contact->sujet, 50) }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($contact->message, 80) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $contact->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contact->status_badge }}">
                                    {{ $contact->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Voir -->
                                    <a href="{{ route('admin.contacts.show', $contact) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Voir">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>

                                    <!-- Menu déroulant pour changer le statut -->
                                    <div class="relative inline-block m-3" x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="text-gray-600 hover:text-gray-900"
                                            title="Changer le statut">
                                            <i class="fas fa-ellipsis-v text-lg"></i>
                                        </button>
                                        <div x-show="open"
                                            @click.away="open = false"
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10 border border-gray-200"
                                            style="display: none;">
                                            <form method="POST" action="{{ route('admin.contacts.status', $contact) }}">
                                                @csrf
                                                <button type="submit" name="status" value="nouveau"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                                    <i class="fas fa-inbox text-blue-500"></i> Nouveau
                                                </button>
                                                <button type="submit" name="status" value="lu"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                                    <i class="fas fa-eye text-yellow-500"></i> Lu
                                                </button>
                                                <button type="submit" name="status" value="traite"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                                    <i class="fas fa-check text-green-500"></i> Traité
                                                </button>
                                                <button type="submit" name="status" value="archive"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                                    <i class="fas fa-archive text-gray-500"></i> Archivé
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Supprimer -->
                                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')" class="inline">
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
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p class="text-lg">Aucun message trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Actions groupées -->
        <div id="bulk-actions" class="hidden bg-gray-50 px-6 py-4 border-t border-gray-200">
            <form method="POST" action="{{ route('admin.contacts.bulk-delete') }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les messages sélectionnés ?')">
                @csrf
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">
                        <span id="selected-count">0</span> message(s) sélectionné(s)
                    </span>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition inline-flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        Supprimer la sélection
                    </button>
                </div>
                <input type="hidden" name="ids" id="selected-ids">
            </form>
        </div>

        <!-- Pagination -->
        @if($contacts->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js pour le menu déroulant -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
// Gestion de la sélection multiple
const selectAll = document.getElementById('select-all');
const checkboxes = document.querySelectorAll('.contact-checkbox');
const bulkActions = document.getElementById('bulk-actions');
const selectedCount = document.getElementById('selected-count');
const selectedIds = document.getElementById('selected-ids');

selectAll?.addEventListener('change', function() {
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checked = document.querySelectorAll('.contact-checkbox:checked');
    const count = checked.length;

    if (count > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = count;

        const ids = Array.from(checked).map(cb => cb.value);
        selectedIds.value = JSON.stringify(ids);
    } else {
        bulkActions.classList.add('hidden');
    }

    selectAll.checked = count === checkboxes.length && count > 0;
}
</script>
@endsection
