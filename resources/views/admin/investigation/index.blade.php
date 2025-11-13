@extends('layouts.admin')

@section('title', 'Gestion des Propositions d\'Investigation')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Propositions d'Investigation</h1>
            <p class="text-gray-600 mt-1">Gérez les propositions d'enquête soumises par les utilisateurs</p>
        </div>
        <div class="flex gap-2">
            <button onclick="refreshData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Actualiser
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-gray-500">
            <div class="text-gray-600 text-sm mb-1">Total</div>
            <div class="text-2xl font-bold text-gray-900" id="stat-total">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="text-gray-600 text-sm mb-1">En attente</div>
            <div class="text-2xl font-bold text-yellow-600" id="stat-pending">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="text-gray-600 text-sm mb-1">Validés</div>
            <div class="text-2xl font-bold text-green-600" id="stat-validated">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="text-gray-600 text-sm mb-1">En cours</div>
            <div class="text-2xl font-bold text-blue-600" id="stat-in-progress">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
            <div class="text-gray-600 text-sm mb-1">Terminés</div>
            <div class="text-2xl font-bold text-purple-600" id="stat-completed">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
            <div class="text-gray-600 text-sm mb-1">Rejetés</div>
            <div class="text-2xl font-bold text-red-600" id="stat-rejected">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500">
            <div class="text-gray-600 text-sm mb-1">Budget total</div>
            <div class="text-lg font-bold text-indigo-600" id="stat-budget">0 F</div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" id="filter-search" placeholder="Titre, email, auteur..."
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="filter-status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="validated">Validé</option>
                    <option value="in_progress">En cours</option>
                    <option value="completed">Terminé</option>
                    <option value="rejected">Rejeté</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thème</label>
                <select id="filter-theme" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les thèmes</option>
                    <option value="Corruption">Corruption</option>
                    <option value="Environnement">Environnement</option>
                    <option value="Santé publique">Santé publique</option>
                    <option value="Justice">Justice</option>
                    <option value="Économie">Économie</option>
                    <option value="Droits humains">Droits humains</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                <select id="filter-format" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les formats</option>
                    <option value="Article long">Article long</option>
                    <option value="Vidéo">Vidéo</option>
                    <option value="Podcast">Podcast</option>
                    <option value="Infographie">Infographie</option>
                    <option value="Série multimédia">Série multimédia</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="applyFilters()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Filtrer
                </button>
            </div>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div id="bulk-actions" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-blue-900 font-medium">
                    <span id="selected-count">0</span> proposition(s) sélectionnée(s)
                </span>
                <button onclick="selectAll()" class="text-blue-600 hover:underline text-sm">
                    Tout sélectionner
                </button>
                <button onclick="deselectAll()" class="text-blue-600 hover:underline text-sm">
                    Tout désélectionner
                </button>
            </div>
            <div class="flex gap-2">
                <button onclick="bulkAction('validate')" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                    Valider
                </button>
                <button onclick="bulkAction('reject')" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                    Rejeter
                </button>
                <button onclick="bulkAction('start')" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    Démarrer
                </button>
                <button onclick="bulkAction('complete')" class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm">
                    Terminer
                </button>
                <button onclick="bulkAction('delete')" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                    Supprimer
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" id="select-all-checkbox" onclick="toggleSelectAll(this)"
                                   class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('id')">
                            ID
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('title')">
                            Titre
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Auteur
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thème / Format
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Budget
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('created_at')">
                            Date
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="proposals-tbody" class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            Chargement des données...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div id="pagination" class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button onclick="previousPage()" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Précédent
                    </button>
                    <button onclick="nextPage()" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Suivant
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage de <span class="font-medium" id="page-from">1</span> à
                            <span class="font-medium" id="page-to">20</span> sur
                            <span class="font-medium" id="page-total">0</span> résultats
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" id="pagination-buttons">
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: View Details --}}
<div id="modal-view" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Détails de la proposition</h3>
            <button onclick="closeModal('view')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="modal-view-content" class="max-h-[70vh] overflow-y-auto">
            <!-- Content loaded dynamically -->
        </div>
    </div>
</div>

{{-- Modal: Validate --}}
<div id="modal-validate" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold mb-4">Valider la proposition</h3>
        <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir valider cette proposition ?</p>
        <div class="flex justify-end gap-2">
            <button onclick="closeModal('validate')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Annuler
            </button>
            <button onclick="confirmValidate()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Valider
            </button>
        </div>
    </div>
</div>

{{-- Modal: Reject --}}
<div id="modal-reject" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold mb-4">Rejeter la proposition</h3>
        <form id="form-reject">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Raison du rejet <span class="text-red-600">*</span>
                </label>
                <textarea id="rejection-reason" rows="4" required minlength="10"
                          class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                          placeholder="Expliquez pourquoi cette proposition est rejetée..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('reject')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Rejeter
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentProposalId = null;
let selectedIds = new Set();
let allProposals = [];
let filters = {
    status: '',
    theme: '',
    format: '',
    search: '',
    sort_by: 'created_at',
    sort_order: 'desc'
};

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadProposals();

    // Setup event listeners
    document.getElementById('filter-search').addEventListener('input', debounce(applyFilters, 500));
    document.getElementById('form-reject').addEventListener('submit', handleRejectSubmit);
});

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Load proposals
async function loadProposals() {
    try {
        const params = new URLSearchParams({
            page: currentPage,
            per_page: 20,
            ...filters
        });

        const response = await fetch(`/api/admin/investigations?${params}`, {
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            allProposals = data.proposals.data;
            renderTable(data.proposals);
            updateStats(data.stats);
            updatePagination(data.proposals);
        }
    } catch (error) {
        console.error('Error loading proposals:', error);
        showNotification('Erreur lors du chargement des données', 'error');
    }
}

// Render table
function renderTable(proposals) {
    const tbody = document.getElementById('proposals-tbody');

    if (!proposals.data || proposals.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                    Aucune proposition trouvée
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = proposals.data.map(proposal => `
        <tr class="hover:bg-gray-50 ${selectedIds.has(proposal.id) ? 'bg-blue-50' : ''}">
            <td class="px-4 py-3">
                <input type="checkbox"
                       class="proposal-checkbox rounded border-gray-300"
                       value="${proposal.id}"
                       ${selectedIds.has(proposal.id) ? 'checked' : ''}
                       onchange="toggleSelect(${proposal.id})">
            </td>
            <td class="px-4 py-3 text-sm text-gray-900">#${proposal.id}</td>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900 max-w-xs truncate">
                    ${proposal.title}
                </div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm text-gray-900">${proposal.user?.prenom} ${proposal.user?.nom}</div>
                <div class="text-xs text-gray-500">${proposal.user?.email}</div>
            </td>
            <td class="px-4 py-3">
                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">${proposal.theme}</span>
                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded mt-1">${proposal.format}</span>
            </td>
            <td class="px-4 py-3 text-sm">
                ${proposal.budget ? `
                    <div class="text-gray-900 font-medium">${formatNumber(proposal.budget)} F</div>
                    <div class="text-xs text-gray-500">${formatNumber(proposal.budget_collected)} collectés</div>
                ` : '<span class="text-gray-400">-</span>'}
            </td>
            <td class="px-4 py-3">
                ${getStatusBadge(proposal.status)}
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">
                ${formatDate(proposal.created_at)}
            </td>
            <td class="px-4 py-3 text-right text-sm">
                <div class="flex justify-end gap-1">
                    <button onclick="viewProposal(${proposal.id})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded"
                            title="Voir">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    ${getQuickActions(proposal)}
                </div>
            </td>
        </tr>
    `).join('');
}

// Get status badge
function getStatusBadge(status) {
    const badges = {
        'pending': '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">En attente</span>',
        'validated': '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Validé</span>',
        'in_progress': '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">En cours</span>',
        'completed': '<span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Terminé</span>',
        'rejected': '<span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Rejeté</span>'
    };
    return badges[status] || status;
}

// Get quick actions
function getQuickActions(proposal) {
    let actions = '';

    if (proposal.status === 'pending') {
        actions += `
            <button onclick="validateProposal(${proposal.id})"
                    class="p-2 text-green-600 hover:bg-green-50 rounded"
                    title="Valider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
            <button onclick="rejectProposal(${proposal.id})"
                    class="p-2 text-red-600 hover:bg-red-50 rounded"
                    title="Rejeter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
    } else if (proposal.status === 'validated') {
        actions += `
            <button onclick="startProposal(${proposal.id})"
                    class="p-2 text-blue-600 hover:bg-blue-50 rounded"
                    title="Démarrer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        `;
    } else if (proposal.status === 'in_progress') {
        actions += `
            <button onclick="completeProposal(${proposal.id})"
                    class="p-2 text-purple-600 hover:bg-purple-50 rounded"
                    title="Terminer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        `;
    }

    actions += `
        <button onclick="deleteProposal(${proposal.id})"
                class="p-2 text-red-600 hover:bg-red-50 rounded"
                title="Supprimer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;

    return actions;
}

// Update stats
function updateStats(stats) {
    document.getElementById('stat-total').textContent = stats.total || 0;
    document.getElementById('stat-pending').textContent = stats.pending || 0;
    document.getElementById('stat-validated').textContent = stats.validated || 0;
    document.getElementById('stat-in-progress').textContent = stats.in_progress || 0;
    document.getElementById('stat-completed').textContent = stats.completed || 0;
    document.getElementById('stat-rejected').textContent = stats.rejected || 0;
    document.getElementById('stat-budget').textContent = formatNumber(stats.total_budget || 0) + ' F';
}

// Update pagination
function updatePagination(proposals) {
    document.getElementById('page-from').textContent = proposals.from || 0;
    document.getElementById('page-to').textContent = proposals.to || 0;
    document.getElementById('page-total').textContent = proposals.total || 0;

    // Generate pagination buttons
    const paginationButtons = document.getElementById('pagination-buttons');
    let buttons = '';

    // Previous button
    if (proposals.current_page > 1) {
        buttons += `<button onclick="goToPage(${proposals.current_page - 1})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Précédent</button>`;
    }

    // Page numbers
    for (let i = 1; i <= proposals.last_page; i++) {
        if (i === proposals.current_page) {
            buttons += `<button class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600">${i}</button>`;
        } else if (i === 1 || i === proposals.last_page || (i >= proposals.current_page - 2 && i <= proposals.current_page + 2)) {
            buttons += `<button onclick="goToPage(${i})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">${i}</button>`;
        } else if (i === proposals.current_page - 3 || i === proposals.current_page + 3) {
            buttons += `<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>`;
        }
    }

    // Next button
    if (proposals.current_page < proposals.last_page) {
        buttons += `<button onclick="goToPage(${proposals.current_page + 1})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Suivant</button>`;
    }

    paginationButtons.innerHTML = buttons;
}

// Apply filters
function applyFilters() {
    filters.status = document.getElementById('filter-status').value;
    filters.theme = document.getElementById('filter-theme').value;
    filters.format = document.getElementById('filter-format').value;
    filters.search = document.getElementById('filter-search').value;
    currentPage = 1;
    loadProposals();
}

// Sort by
function sortBy(field) {
    if (filters.sort_by === field) {
        filters.sort_order = filters.sort_order === 'asc' ? 'desc' : 'asc';
    } else {
        filters.sort_by = field;
        filters.sort_order = 'asc';
    }
    loadProposals();
}

// Pagination
function goToPage(page) {
    currentPage = page;
    loadProposals();
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        loadProposals();
    }
}

function nextPage() {
    currentPage++;
    loadProposals();
}

// Selection management
function toggleSelect(id) {
    if (selectedIds.has(id)) {
        selectedIds.delete(id);
    } else {
        selectedIds.add(id);
    }
    updateBulkActions();
}

function toggleSelectAll(checkbox) {
    if (checkbox.checked) {
        allProposals.forEach(p => selectedIds.add(p.id));
    } else {
        selectedIds.clear();
    }
    document.querySelectorAll('.proposal-checkbox').forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateBulkActions();
}

function selectAll() {
    allProposals.forEach(p => selectedIds.add(p.id));
    document.querySelectorAll('.proposal-checkbox').forEach(cb => cb.checked = true);
    document.getElementById('select-all-checkbox').checked = true;
    updateBulkActions();
}

function deselectAll() {
    selectedIds.clear();
    document.querySelectorAll('.proposal-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('select-all-checkbox').checked = false;
    updateBulkActions();
}

function updateBulkActions() {
    const bulkDiv = document.getElementById('bulk-actions');
    const count = selectedIds.size;

    if (count > 0) {
        bulkDiv.classList.remove('hidden');
        document.getElementById('selected-count').textContent = count;
    } else {
        bulkDiv.classList.add('hidden');
    }

    loadProposals();
}

// Download file
async function downloadFile(filePath, fileName) {
    try {
        const response = await fetch(`/api/admin/investigations/download-file`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ file_path: filePath })
        });

        if (!response.ok) {
            throw new Error('Erreur lors du téléchargement');
        }

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

    } catch (error) {
        console.error('Error downloading file:', error);
        showNotification('Erreur lors du téléchargement du fichier', 'error');
    }
}

// Actions
async function viewProposal(id) {
    currentProposalId = id;
    try {
        const response = await fetch(`/api/admin/investigations/${id}`, {
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const proposal = data.proposal;

            let filesHtml = '';
            if (proposal.files && proposal.files.length > 0) {
                filesHtml = `
                    <div>
                        <h4 class="font-semibold mb-2">Fichiers joints</h4>
                        <div class="space-y-2">
                            ${proposal.files.map(file => `
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">${file.name}</div>
                                            <div class="text-xs text-gray-500">${formatFileSize(file.size)}</div>
                                        </div>
                                    </div>
                                    <button onclick="downloadFile('${file.path}', '${file.name}')"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded"
                                            title="Télécharger">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }

            document.getElementById('modal-view-content').innerHTML = `
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold mb-2">Titre</h4>
                        <p>${proposal.title}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Auteur</h4>
                        <p>${proposal.user.prenom} ${proposal.user.nom} (${proposal.user.email})</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold mb-2">Thème</h4>
                            <p>${proposal.theme}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Format</h4>
                            <p>${proposal.format}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Angle d'investigation</h4>
                        <p class="whitespace-pre-wrap">${proposal.angle}</p>
                    </div>
                    ${proposal.sources ? `
                        <div>
                            <h4 class="font-semibold mb-2">Sources</h4>
                            <p class="whitespace-pre-wrap">${proposal.sources}</p>
                        </div>
                    ` : ''}
                    ${proposal.needs ? `
                        <div>
                            <h4 class="font-semibold mb-2">Besoins</h4>
                            <p class="whitespace-pre-wrap">${proposal.needs}</p>
                        </div>
                    ` : ''}
                    <div class="grid grid-cols-3 gap-4">
                        ${proposal.budget ? `
                            <div>
                                <h4 class="font-semibold mb-2">Budget</h4>
                                <p>${formatNumber(proposal.budget)} F</p>
                            </div>
                        ` : ''}
                        ${proposal.estimated_weeks ? `
                            <div>
                                <h4 class="font-semibold mb-2">Durée estimée</h4>
                                <p>${proposal.estimated_weeks} semaines</p>
                            </div>
                        ` : ''}
                        <div>
                            <h4 class="font-semibold mb-2">Statut</h4>
                            <p>${getStatusBadge(proposal.status)}</p>
                        </div>
                    </div>
                    ${filesHtml}
                    ${proposal.rejection_reason ? `
                        <div class="bg-red-50 border border-red-200 rounded p-3">
                            <h4 class="font-semibold text-red-800 mb-2">Raison du rejet</h4>
                            <p class="text-red-700">${proposal.rejection_reason}</p>
                        </div>
                    ` : ''}
                </div>
            `;
            openModal('view');
        }
    } catch (error) {
        showNotification('Erreur lors du chargement des détails', 'error');
    }
}

function validateProposal(id) {
    currentProposalId = id;
    openModal('validate');
}

async function confirmValidate() {
    try {
        const response = await fetch(`/api/admin/investigations/${currentProposalId}/validate`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition validée avec succès', 'success');
            closeModal('validate');
            loadProposals();
        } else {
            showNotification(result.message || 'Erreur lors de la validation', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors de la validation', 'error');
    }
}

function rejectProposal(id) {
    currentProposalId = id;
    document.getElementById('rejection-reason').value = '';
    openModal('reject');
}

async function handleRejectSubmit(e) {
    e.preventDefault();
    const reason = document.getElementById('rejection-reason').value;

    try {
        const response = await fetch(`/api/admin/investigations/${currentProposalId}/reject`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ rejection_reason: reason })
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition rejetée avec succès', 'success');
            closeModal('reject');
            loadProposals();
        } else {
            showNotification(result.message || 'Erreur lors du rejet', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors du rejet', 'error');
    }
}

async function startProposal(id) {
    if (!confirm('Démarrer cette investigation ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${id}/start`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Investigation démarrée', 'success');
            loadProposals();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors du démarrage', 'error');
    }
}

async function completeProposal(id) {
    if (!confirm('Marquer cette investigation comme terminée ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${id}/complete`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Investigation marquée comme terminée', 'success');
            loadProposals();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function deleteProposal(id) {
    if (!confirm('Supprimer cette proposition ? (soft delete)')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition supprimée', 'success');
            loadProposals();
        } else {
            showNotification('Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors de la suppression', 'error');
    }
}

// Bulk actions
async function bulkAction(action) {
    if (selectedIds.size === 0) {
        showNotification('Aucune proposition sélectionnée', 'warning');
        return;
    }

    let reason = null;
    if (action === 'reject') {
        reason = prompt('Raison du rejet:');
        if (!reason) return;
    }

    const confirmMsg = `Appliquer l'action "${action}" à ${selectedIds.size} proposition(s) ?`;
    if (!confirm(confirmMsg)) return;

    try {
        const response = await fetch('/api/admin/investigations/bulk-action', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                action,
                ids: Array.from(selectedIds),
                rejection_reason: reason
            })
        });

        const result = await response.json();

        if (result.success) {
            showNotification(`${result.count} proposition(s) traitée(s)`, 'success');
            deselectAll();
            loadProposals();
        } else {
            showNotification('Erreur lors du traitement en masse', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors du traitement en masse', 'error');
    }
}

// Modal management
function openModal(modalName) {
    document.getElementById(`modal-${modalName}`).classList.remove('hidden');
}

function closeModal(modalName) {
    document.getElementById(`modal-${modalName}`).classList.add('hidden');
}

// Utility functions
function getToken() {
    return localStorage.getItem('auth_token') || '';
}

function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(num);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

function showNotification(message, type = 'info') {
    alert(message);
}

function refreshData() {
    loadProposals();
}
</script>
@endpush
