@extends('layouts.admin')

@section('title', 'Soumissions Communauté')
@section('page-title', 'Soumissions Communauté')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Soumissions</h2>
            <p class="text-gray-600 mt-1">Gérez les contenus soumis par la communauté</p>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('admin.community.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Titre, contenu..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>Validé</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les types</option>
                <option value="article" {{ request('type') === 'article' ? 'selected' : '' }}>Article</option>
                <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Information</option>
                <option value="alert" {{ request('type') === 'alert' ? 'selected' : '' }}>Alerte</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Filtrer
            </button>
            <a href="{{ route('admin.community.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Actions en masse -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <form id="bulkActionForm" method="POST" action="{{ route('admin.community.bulk-action') }}">
        @csrf
        <div class="flex items-center gap-4">
            <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 rounded">
            <label for="selectAll" class="text-sm font-medium text-gray-700">Tout sélectionner</label>

            <select name="action" id="bulkAction" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Action groupée...</option>
                <option value="validate">Valider</option>
                <option value="reject">Rejeter</option>
                <option value="publish">Publier</option>
                <option value="unpublish">Dépublier</option>
                <option value="delete">Supprimer</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Appliquer
            </button>
        </div>
    </form>
</div>

<!-- Liste des soumissions -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Titre & Auteur
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Type
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($submissions as $submission)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <input type="checkbox" name="ids[]" value="{{ $submission->id }}" class="submission-checkbox w-4 h-4 text-blue-600 rounded">
                </td>
                <td class="px-6 py-4">
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            {{ Str::limit($submission->title, 60) }}
                        </div>
                        <div class="text-sm text-gray-500">
                            Par {{ $submission->user->nom }} {{ $submission->user->prenom }} ({{ $submission->user->email }})
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $submission->type === 'article' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $submission->type === 'info' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $submission->type === 'alert' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($submission->type) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $submission->status === 'validated' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $submission->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : '' }}">
                        @switch($submission->status)
                            @case('pending') En attente @break
                            @case('validated') Validé @break
                            @case('rejected') Rejeté @break
                            @case('published') Publié @break
                        @endswitch
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $submission->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.community.show', $submission) }}"
                           class="text-blue-600 hover:text-blue-900">
                            Voir
                        </a>

                        @if($submission->status === 'pending')
                        <form method="POST" action="{{ route('admin.community.validate', $submission) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900">
                                Valider
                            </button>
                        </form>
                        @endif

                        @if($submission->status === 'validated' && !$submission->published_at)
                        <form method="POST" action="{{ route('admin.community.publish', $submission) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900">
                                Publier
                            </button>
                        </form>
                        @endif

                        <form method="POST" action="{{ route('admin.community.destroy', $submission) }}"
                              class="inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    Aucune soumission trouvée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($submissions->hasPages())
<div class="mt-6">
    {{ $submissions->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
    // Sélection multiple
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.submission-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Validation du formulaire d'actions groupées
    document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
        const action = document.getElementById('bulkAction').value;
        const checkedBoxes = document.querySelectorAll('.submission-checkbox:checked');

        if (!action) {
            e.preventDefault();
            alert('Veuillez sélectionner une action');
            return;
        }

        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins une soumission');
            return;
        }

        if (!confirm(`Êtes-vous sûr de vouloir ${action} ${checkedBoxes.length} soumission(s) ?`)) {
            e.preventDefault();
        }
    });
</script>
@endpush
