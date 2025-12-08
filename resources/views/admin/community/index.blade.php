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

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="text-sm text-gray-600">Total</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-yellow-50 rounded-lg shadow-sm p-4">
        <div class="text-sm text-yellow-600">En attente</div>
        <div class="text-2xl font-bold text-yellow-900">{{ $stats['pending'] }}</div>
    </div>
    <div class="bg-blue-50 rounded-lg shadow-sm p-4">
        <div class="text-sm text-blue-600">Validé</div>
        <div class="text-2xl font-bold text-blue-900">{{ $stats['validated'] }}</div>
    </div>
    <div class="bg-red-50 rounded-lg shadow-sm p-4">
        <div class="text-sm text-red-600">Rejeté</div>
        <div class="text-2xl font-bold text-red-900">{{ $stats['rejected'] }}</div>
    </div>
    <div class="bg-green-50 rounded-lg shadow-sm p-4">
        <div class="text-sm text-green-600">Publié</div>
        <div class="text-2xl font-bold text-green-900">{{ $stats['published'] }}</div>
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
            <select name="section" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Toutes les sections</option>
                <option value="Société" {{ request('section') === 'Société' ? 'selected' : '' }}>Société</option>
                <option value="Économie" {{ request('section') === 'Économie' ? 'selected' : '' }}>Économie</option>
                <option value="Politique" {{ request('section') === 'Politique' ? 'selected' : '' }}>Politique</option>
                <option value="Tech & IA" {{ request('section') === 'Tech & IA' ? 'selected' : '' }}>Tech & IA</option>
                <option value="Culture" {{ request('section') === 'Culture' ? 'selected' : '' }}>Culture</option>
                <option value="Environnement" {{ request('section') === 'Environnement' ? 'selected' : '' }}>Environnement</option>
                <option value="Investigation" {{ request('section') === 'Investigation' ? 'selected' : '' }}>Investigation</option>
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
{{-- <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
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

            <input type="text" name="rejection_reason" id="rejectionReasonBulk"
                   placeholder="Raison du rejet (obligatoire pour rejeter)"
                   class="hidden px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 flex-1">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Appliquer
            </button>
        </div>
    </form>
</div> --}}

<!-- Liste des soumissions -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        #
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titre & Auteur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Section
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
                @php
                    $i = 1;
                @endphp
                @forelse($submissions as $submission)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        {{ $i++ }}
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ Str::limit($submission->title, 60) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Par {{ $submission->user->nom }} {{ $submission->user->prenom }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ $submission->section }}
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
                            <button onclick="viewSubmission({{ $submission->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                Voir
                            </button>

                            @if($submission->status === 'pending')
                            <button onclick="quickValidate({{ $submission->id }})"
                                    class="text-green-600 hover:text-green-900">
                                Valider
                            </button>
                            @endif

                            @if($submission->status === 'validated' && !$submission->published_at)
                            <button onclick="quickPublish({{ $submission->id }})"
                                    class="text-green-600 hover:text-green-900">
                                Publier
                            </button>
                            @endif

                            <button onclick="deleteSubmission({{ $submission->id }})"
                                    class="text-red-600 hover:text-red-900">
                                Supprimer
                            </button>
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
</div>

<!-- Pagination -->
@if($submissions->hasPages())
<div class="mt-6">
    {{ $submissions->links() }}
</div>
@endif

<!-- Modal de détails -->
<div id="submissionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-5xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-gray-900" id="modalTitle"></h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div id="modalContent" class="space-y-6">
            <!-- Le contenu sera injecté ici -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentSubmissionId = null;

// Sélection multiple
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// Afficher/masquer le champ raison de rejet
document.getElementById('bulkAction').addEventListener('change', function() {
    const rejectionField = document.getElementById('rejectionReasonBulk');
    if (this.value === 'reject') {
        rejectionField.classList.remove('hidden');
    } else {
        rejectionField.classList.add('hidden');
    }
});

// Validation du formulaire d'actions groupées
document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const action = document.getElementById('bulkAction').value;
    const checkedBoxes = document.querySelectorAll('.submission-checkbox:checked');
    const rejectionReason = document.getElementById('rejectionReasonBulk').value;

    if (!action) {
        alert('Veuillez sélectionner une action');
        return;
    }

    if (checkedBoxes.length === 0) {
        alert('Veuillez sélectionner au moins une soumission');
        return;
    }

    if (action === 'reject' && !rejectionReason.trim()) {
        alert('Veuillez fournir une raison pour le rejet');
        return;
    }

    if (!confirm(`Êtes-vous sûr de vouloir ${action} ${checkedBoxes.length} soumission(s) ?`)) {
        return;
    }

    // Récupérer les IDs
    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    // Envoyer la requête
    fetch('{{ route("admin.community.bulk-action") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            action: action,
            ids: ids,
            rejection_reason: rejectionReason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
});

// Voir les détails d'une soumission
function viewSubmission(id) {
    currentSubmissionId = id;

    fetch(`/admin/community/${id}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displaySubmission(data.submission);
            document.getElementById('submissionModal').classList.remove('hidden');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Afficher les détails dans le modal
function displaySubmission(submission) {
    document.getElementById('modalTitle').textContent = submission.title;

    const statusLabels = {
        pending: 'En attente',
        validated: 'Validé',
        rejected: 'Rejeté',
        published: 'Publié'
    };

    const statusColors = {
        pending: 'bg-yellow-100 text-yellow-800',
        validated: 'bg-blue-100 text-blue-800',
        rejected: 'bg-red-100 text-red-800',
        published: 'bg-green-100 text-green-800'
    };

    let actionsHtml = '';

    if (submission.status === 'pending') {
        actionsHtml = `
            <button onclick="validateSubmission(${submission.id})"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Valider
            </button>
            <button onclick="showRejectForm(${submission.id})"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Rejeter
            </button>
        `;
    } else if (submission.status === 'validated' && !submission.published_at) {
        actionsHtml = `
            <button onclick="publishSubmission(${submission.id})"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Publier
            </button>
        `;
    } else if (submission.published_at) {
        actionsHtml = `
            <button onclick="unpublishSubmission(${submission.id})"
                    class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Dépublier
            </button>
        `;
    }

    const content = `
        <div class="grid grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Informations générales</h4>
                <div class="space-y-2 text-sm">
                    <div><span class="font-medium">Auteur:</span> ${submission.user.nom} ${submission.user.prenom}</div>
                    <div><span class="font-medium">Email:</span> ${submission.user.email}</div>
                    <div><span class="font-medium">Section:</span> ${submission.section}</div>
                    <div><span class="font-medium">Accès:</span> ${submission.access_type === 'premium' ? 'Premium' : 'Gratuit'}</div>
                    <div><span class="font-medium">Statut:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColors[submission.status]}">
                            ${statusLabels[submission.status]}
                        </span>
                    </div>
                    <div><span class="font-medium">Date de soumission:</span> ${new Date(submission.created_at).toLocaleString('fr-FR')}</div>
                    ${submission.validated_at ? `<div><span class="font-medium">Date de validation:</span> ${new Date(submission.validated_at).toLocaleString('fr-FR')}</div>` : ''}
                    ${submission.published_at ? `<div><span class="font-medium">Date de publication:</span> ${new Date(submission.published_at).toLocaleString('fr-FR')}</div>` : ''}
                </div>
            </div>

            ${submission.image_path ? `
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Image</h4>
                <img src="/storage/${submission.image_path}" alt="Image" class="w-full rounded-lg shadow-md">
                <a href="/storage/${submission.image_path}" download class="mt-2 inline-block text-blue-600 hover:text-blue-800 text-sm">
                    Télécharger l'image
                </a>
            </div>
            ` :
`
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Aucun fichier</h4>

            </div>
            `
            }
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-gray-700 mb-2">Résumé</h4>
            <div class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg text-justify">
                ${submission.summary || 'Aucun résumé'}
            </div>
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-gray-700 mb-2">Contenu complet</h4>
            <div class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg max-h-96 overflow-y-auto text-justify">
                ${submission.content || 'Aucun contenu'}
            </div>
        </div>

        ${submission.rejection_reason ? `
        <div class="mt-6">
            <h4 class="font-semibold text-red-700 mb-2">Raison du rejet</h4>
            <div class="text-sm text-red-600 bg-red-50 p-4 rounded-lg">
                ${submission.rejection_reason}
            </div>
        </div>
        ` : ''}

        <div id="rejectFormContainer" class="hidden mt-6">
            <h4 class="font-semibold text-gray-700 mb-2">Raison du rejet</h4>
            <textarea id="rejectionReasonModal"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                      rows="4"
                      placeholder="Expliquez pourquoi cette soumission est rejetée..."></textarea>
            <div class="flex gap-2 mt-2">
                <button onclick="confirmReject()"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Confirmer le rejet
                </button>
                <button onclick="hideRejectForm()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Annuler
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6 pt-6 border-t">
            <button onclick="closeModal()"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Fermer
            </button>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = content;
}

// Validation rapide
function quickValidate(id) {
    if (!confirm('Voulez-vous valider cette soumission ?')) return;

    fetch(`/admin/community/${id}/validate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    });
}

// Publication rapide
function quickPublish(id) {
    if (!confirm('Voulez-vous publier cette soumission ?')) return;

    fetch(`/admin/community/${id}/publish`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    });
}

// Valider depuis le modal
function validateSubmission(id) {
    if (!confirm('Voulez-vous valider cette soumission ?')) return;

    fetch(`/admin/community/${id}/validate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload();
        }
    });
}

// Afficher le formulaire de rejet
function showRejectForm() {
    document.getElementById('rejectFormContainer').classList.remove('hidden');
}

function hideRejectForm() {
    document.getElementById('rejectFormContainer').classList.add('hidden');
    document.getElementById('rejectionReasonModal').value = '';
}

// Confirmer le rejet
function confirmReject() {
    const reason = document.getElementById('rejectionReasonModal').value.trim();

    if (!reason) {
        alert('Veuillez fournir une raison pour le rejet');
        return;
    }

    if (reason.length < 10) {
        alert('La raison doit contenir au moins 10 caractères');
        return;
    }

    fetch(`/admin/community/${currentSubmissionId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            rejection_reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    });
}

// Publier une soumission
function publishSubmission(id) {
    if (!confirm('Voulez-vous publier cette soumission ?')) return;

    fetch(`/admin/community/${id}/publish`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload();
        }
    });
}

// Dépublier une soumission
function unpublishSubmission(id) {
    if (!confirm('Voulez-vous dépublier cette soumission ?')) return;

    fetch(`/admin/community/${id}/unpublish`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload();
        }
    });
}

// Supprimer une soumission
function deleteSubmission(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?')) return;

    fetch(`/admin/community/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    });
}

// Afficher le formulaire de modification
function showEditForm(id) {
    // Vous pouvez implémenter un formulaire d'édition ici
    alert('Fonctionnalité de modification à implémenter selon vos besoins');
}

// Fermer le modal
function closeModal() {
    document.getElementById('submissionModal').classList.add('hidden');
    currentSubmissionId = null;
}

// Fermer le modal en cliquant en dehors
document.getElementById('submissionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
