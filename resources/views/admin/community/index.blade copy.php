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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
            <input type="text" id="searchInput" placeholder="Titre, contenu..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="validated">Validé</option>
                <option value="rejected">Rejeté</option>
                <option value="published">Publié</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
            <select id="typeFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Tous les types</option>
                <option value="article">Article</option>
                <option value="info">Information</option>
                <option value="alert">Alerte</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button onclick="loadSubmissions()" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Filtrer
            </button>
            <button onclick="resetFilters()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Réinitialiser
            </button>
        </div>
    </div>
</div>

<!-- Actions en masse -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <div class="flex items-center gap-4">
        <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 rounded">
        <label for="selectAll" class="text-sm font-medium text-gray-700">Tout sélectionner</label>

        <select id="bulkAction" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Action groupée...</option>
            <option value="validate">Valider</option>
            <option value="reject">Rejeter</option>
            <option value="publish">Publier</option>
            <option value="unpublish">Dépublier</option>
            <option value="delete">Supprimer</option>
        </select>

        <button onclick="executeBulkAction()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Appliquer
        </button>
    </div>
</div>

<!-- Loading spinner -->
<div id="loadingSpinner" class="hidden text-center py-12">
    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    <p class="mt-4 text-gray-600">Chargement...</p>
</div>

<!-- Liste des soumissions -->
<div id="submissionsContainer" class="bg-white rounded-lg shadow-sm overflow-hidden">
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
        <tbody id="submissionsTableBody" class="bg-white divide-y divide-gray-200">
            <!-- Les données seront chargées ici via JavaScript -->
        </tbody>
    </table>
</div>

<!-- Message si vide -->
<div id="emptyMessage" class="hidden bg-white rounded-lg shadow-sm p-12 text-center text-gray-500">
    Aucune soumission trouvée
</div>

<!-- Pagination -->
<div id="paginationContainer" class="mt-6"></div>
@endsection

@push('scripts')
<script>
const API_BASE = '{{ route("admin.community.index") }}';
const CSRF_TOKEN = '{{ csrf_token() }}';
let currentPage = 1;

// Charger les soumissions
async function loadSubmissions(page = 1) {
    showLoading(true);

    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const type = document.getElementById('typeFilter').value;

    const params = new URLSearchParams({
        page: page,
        ...(search && { search }),
        ...(status && { status }),
        ...(type && { type })
    });

    try {
        const response = await fetch(`${API_BASE}?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            renderSubmissions(data.data.data);
            renderPagination(data.data);
            currentPage = page;
        } else {
            showError(data.message || 'Erreur lors du chargement');
        }
    } catch (error) {
        showError('Erreur de connexion');
        console.error(error);
    } finally {
        showLoading(false);
    }
}

// Afficher les soumissions
function renderSubmissions(submissions) {
    const tbody = document.getElementById('submissionsTableBody');
    const emptyMessage = document.getElementById('emptyMessage');
    const container = document.getElementById('submissionsContainer');

    if (!submissions || submissions.length === 0) {
        container.classList.add('hidden');
        emptyMessage.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyMessage.classList.add('hidden');

    tbody.innerHTML = submissions.map(sub => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">
                <input type="checkbox" data-id="${sub.id}" class="submission-checkbox w-4 h-4 text-blue-600 rounded">
            </td>
            <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">${truncate(sub.title, 60)}</div>
                <div class="text-sm text-gray-500">Par ${sub.author_name} (${sub.author_email})</div>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${getTypeBadgeClass(sub.type)}">
                    ${capitalizeFirst(sub.type)}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusBadgeClass(sub.status)}">
                    ${getStatusLabel(sub.status)}
                </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-500">
                ${formatDate(sub.created_at)}
            </td>
            <td class="px-6 py-4 text-right text-sm font-medium">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.community.index') }}/${sub.id}" class="text-blue-600 hover:text-blue-900">Voir</a>
                    ${renderQuickActions(sub)}
                    <button onclick="deleteSubmission(${sub.id})" class="text-red-600 hover:text-red-900">Supprimer</button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Actions rapides selon le statut
function renderQuickActions(sub) {
    if (sub.status === 'pending') {
        return `<button onclick="validateSubmission(${sub.id})" class="text-green-600 hover:text-green-900">Valider</button>`;
    } else if (sub.status === 'validated' && !sub.published_at) {
        return `<button onclick="publishSubmission(${sub.id})" class="text-green-600 hover:text-green-900">Publier</button>`;
    }
    return '';
}

// Valider une soumission
async function validateSubmission(id) {
    if (!confirm('Valider cette soumission ?')) return;

    try {
        const response = await fetch(`{{ route('admin.community.index') }}/${id}/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showSuccess(data.message);
            loadSubmissions(currentPage);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Erreur lors de la validation');
    }
}

// Publier une soumission
async function publishSubmission(id) {
    if (!confirm('Publier cette soumission ?')) return;

    try {
        const response = await fetch(`{{ route('admin.community.index') }}/${id}/publish`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showSuccess(data.message);
            loadSubmissions(currentPage);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Erreur lors de la publication');
    }
}

// Supprimer une soumission
async function deleteSubmission(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?')) return;

    try {
        const response = await fetch(`{{ route('admin.community.index') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showSuccess(data.message);
            loadSubmissions(currentPage);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Erreur lors de la suppression');
    }
}

// Actions en masse
async function executeBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const checkboxes = document.querySelectorAll('.submission-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.dataset.id);

    if (!action) {
        showError('Veuillez sélectionner une action');
        return;
    }

    if (ids.length === 0) {
        showError('Veuillez sélectionner au moins une soumission');
        return;
    }

    if (!confirm(`Êtes-vous sûr de vouloir ${action} ${ids.length} soumission(s) ?`)) return;

    try {
        const response = await fetch('{{ route("admin.community.bulk-action") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action, ids })
        });

        const data = await response.json();

        if (data.success) {
            showSuccess(data.message);
            loadSubmissions(currentPage);
            document.getElementById('selectAll').checked = false;
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Erreur lors de l\'action groupée');
    }
}

// Pagination
function renderPagination(data) {
    const container = document.getElementById('paginationContainer');
    if (data.last_page <= 1) {
        container.innerHTML = '';
        return;
    }

    let html = '<div class="flex justify-center gap-2">';

    if (data.current_page > 1) {
        html += `<button onclick="loadSubmissions(${data.current_page - 1})" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Précédent</button>`;
    }

    for (let i = 1; i <= data.last_page; i++) {
        if (i === data.current_page) {
            html += `<button class="px-4 py-2 bg-blue-600 text-white rounded-lg">${i}</button>`;
        } else if (Math.abs(i - data.current_page) <= 2 || i === 1 || i === data.last_page) {
            html += `<button onclick="loadSubmissions(${i})" class="px-4 py-2 border rounded-lg hover:bg-gray-50">${i}</button>`;
        } else if (Math.abs(i - data.current_page) === 3) {
            html += `<span class="px-4 py-2">...</span>`;
        }
    }

    if (data.current_page < data.last_page) {
        html += `<button onclick="loadSubmissions(${data.current_page + 1})" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Suivant</button>`;
    }

    html += '</div>';
    container.innerHTML = html;
}

// Utilitaires
function truncate(str, length) {
    return str.length > length ? str.substring(0, length) + '...' : str;
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function getTypeBadgeClass(type) {
    const classes = {
        article: 'bg-blue-100 text-blue-800',
        info: 'bg-green-100 text-green-800',
        alert: 'bg-red-100 text-red-800'
    };
    return classes[type] || 'bg-gray-100 text-gray-800';
}

function getStatusBadgeClass(status) {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        validated: 'bg-blue-100 text-blue-800',
        rejected: 'bg-red-100 text-red-800',
        published: 'bg-green-100 text-green-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
}

function getStatusLabel(status) {
    const labels = {
        pending: 'En attente',
        validated: 'Validé',
        rejected: 'Rejeté',
        published: 'Publié'
    };
    return labels[status] || status;
}

function showLoading(show) {
    document.getElementById('loadingSpinner').classList.toggle('hidden', !show);
    document.getElementById('submissionsContainer').classList.toggle('hidden', show);
}

function showSuccess(message) {
    const div = document.createElement('div');
    div.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50';
    div.textContent = message;
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

function showError(message) {
    const div = document.createElement('div');
    div.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50';
    div.textContent = message;
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('typeFilter').value = '';
    loadSubmissions(1);
}

// Sélection multiple
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.submission-checkbox').forEach(cb => cb.checked = this.checked);
});

// Charger au démarrage
document.addEventListener('DOMContentLoaded', () => loadSubmissions());
</script>
@endpush
