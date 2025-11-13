@extends('layouts.admin')

@section('title', 'Gestion des Témoignages')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header avec stats -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Gestion des Témoignages</h1>

        <!-- Statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-blue-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Total</div>
                <div class="text-2xl font-bold text-gray-900" id="stat-total">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-yellow-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">En attente</div>
                <div class="text-2xl font-bold text-yellow-600" id="stat-pending">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-green-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Validés</div>
                <div class="text-2xl font-bold text-green-600" id="stat-validated">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-red-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Rejetés</div>
                <div class="text-2xl font-bold text-red-600" id="stat-rejected">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-purple-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Publiés</div>
                <div class="text-2xl font-bold text-purple-600" id="stat-published">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-gray-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Anonymes</div>
                <div class="text-2xl font-bold text-gray-600" id="stat-anonymous">0</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-t-4 border-indigo-500">
                <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Vues totales</div>
                <div class="text-2xl font-bold text-indigo-600" id="stat-views">0</div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text"
                           id="search"
                           placeholder="Titre, description, auteur, email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Filtre statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select id="filter-status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="validated">Validés</option>
                        <option value="rejected">Rejetés</option>
                        <option value="published">Publiés</option>
                    </select>
                </div>

                <!-- Filtre catégorie -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select id="filter-category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Toutes les catégories</option>
                        <option value="corruption">Corruption</option>
                        <option value="injustice">Injustice</option>
                        <option value="violence">Violence</option>
                        <option value="fraude">Fraude</option>
                        <option value="environnement">Environnement</option>
                        <option value="sante">Santé</option>
                        <option value="education">Éducation</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
            </div>

            <!-- Filtres additionnels -->
            <div class="flex items-center gap-4 mt-4">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="filter-anonymous" class="mr-2 rounded">
                    <span class="text-sm text-gray-700">Anonymes uniquement</span>
                </label>

                <button onclick="resetFilters()" class="ml-auto text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Réinitialiser les filtres
                </button>
            </div>
        </div>

        <!-- Actions en masse -->
        {{-- <div id="bulk-actions" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 hidden">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-blue-900">
                        <span id="selected-count">0</span> témoignage(s) sélectionné(s)
                    </span>
                    <button onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                        Tout sélectionner
                    </button>
                    <button onclick="deselectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                        Tout désélectionner
                    </button>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <button onclick="bulkAction('validate')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
                        Valider
                    </button>
                    <button onclick="showBulkRejectModal()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                        Rejeter
                    </button>
                    <button onclick="bulkAction('publish')" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm font-medium">
                        Publier
                    </button>
                    <button onclick="bulkAction('unpublish')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">
                        Dépublier
                    </button>
                    <button onclick="confirmBulkDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                        Supprimer
                    </button>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Liste des témoignages -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        {{-- <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all-checkbox" onchange="toggleSelectAll()" class="rounded">
                        </th> --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('id')">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('title')">
                            Titre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Auteur
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Catégorie
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('views')">
                            Vues
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('created_at')">
                            Date
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="testimonies-tbody" class="bg-white divide-y divide-gray-200">
                    <!-- Chargement via JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Affichage de <span id="showing-from">0</span> à <span id="showing-to">0</span> sur <span id="showing-total">0</span> témoignages
                </div>
                <div id="pagination-links" class="flex gap-2">
                    <!-- Pagination via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de détails -->
<div id="details-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Détails du témoignage</h2>
                    <button onclick="closeDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="testimony-details-content">
                    <!-- Contenu chargé via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Rejeter le témoignage</h3>
                <textarea id="rejection-reason"
                          rows="4"
                          placeholder="Raison du rejet (minimum 10 caractères)..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">
                        Annuler
                    </button>
                    <button onclick="confirmReject()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Confirmer le rejet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let testimonies = [];
let currentPage = 1;
let lastPage = 1;
let selectedIds = new Set();
let currentTestimonyId = null;
let currentFilters = {
    search: '',
    status: '',
    category: '',
    anonymous: false,
    sort_by: 'created_at',
    sort_order: 'desc'
};

// Charger les témoignages
async function loadTestimonies(page = 1) {
    try {
        const params = new URLSearchParams({
            page: page,
            per_page: 20,
            ...currentFilters
        });

        const response = await fetch(`/admin/testimonies?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            testimonies = data.testimonies.data;
            currentPage = data.testimonies.current_page;
            lastPage = data.testimonies.last_page;

            updateStats(data.stats);
            displayTestimonies();
            updatePagination(data.testimonies);
        }
    } catch (error) {
        console.error('Erreur de chargement:', error);
        showNotification('Erreur de chargement des témoignages', 'error');
    }
}

// Afficher les témoignages
function displayTestimonies() {
    const tbody = document.getElementById('testimonies-tbody');

    if (testimonies.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                    Aucun témoignage trouvé
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = testimonies.map(testimony => `
        <tr class="hover:bg-gray-50 ${selectedIds.has(testimony.id) ? 'bg-blue-50' : ''}">

            <td class="px-6 py-4 text-sm text-gray-900">#${testimony.id}</td>
            <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">${escapeHtml(testimony.title)}</div>
                ${testimony.anonymous_publication ? '<span class="text-xs text-gray-500 italic">Anonyme</span>' : ''}
            </td>
            <td class="px-6 py-4">
                ${testimony.anonymous_publication ?
                    '<span class="text-sm text-gray-500 italic">Anonyme</span>' :
                    `<div class="text-sm text-gray-900">${escapeHtml(testimony.user?.prenom || '')} ${escapeHtml(testimony.user?.nom || '')}</div>
                    <div class="text-xs text-gray-500">${escapeHtml(testimony.user?.email || '')}</div>`
                }
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs rounded-full ${getCategoryColor(testimony.category)}">
                    ${getCategoryLabel(testimony.category)}
                </span>
            </td>
            <td class="px-5 py-4">
                ${getStatusBadge(testimony.status)}
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">${testimony.views || 0}</td>
            <td class="px-6 py-4 text-sm text-gray-500">${formatDate(testimony.created_at)}</td>
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center gap-2">
                    <button onclick="showDetails(${testimony.id})"
                            class="text-blue-600 hover:text-blue-800"
                            title="Voir les détails">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                    ${getQuickActions(testimony)}
                </div>
            </td>
        </tr>
    `).join('');
}

// Actions rapides selon le statut
function getQuickActions(testimony) {
    const actions = [];

    if (testimony.status === 'pending') {
        actions.push(`
            <button onclick="quickValidate(${testimony.id})"
                    class="text-green-600 hover:text-green-800"
                    title="Valider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>
        `);
        actions.push(`
            <button onclick="showRejectModal(${testimony.id})"
                    class="text-red-600 hover:text-red-800"
                    title="Rejeter">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `);
    }

    if (testimony.status === 'validated') {
        actions.push(`
            <button onclick="quickPublish(${testimony.id})"
                    class="text-purple-600 hover:text-purple-800"
                    title="Publier">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </button>
        `);
    }

    if (testimony.status === 'published') {
        actions.push(`
            <button onclick="quickUnpublish(${testimony.id})"
                    class="text-gray-600 hover:text-gray-800"
                    title="Dépublier">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                </svg>
            </button>
        `);
    }

    actions.push(`
        <button onclick="confirmDelete(${testimony.id})"
                class="text-red-600 hover:text-red-800"
                title="Supprimer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `);

    return actions.join('');
}

// Afficher les détails
async function showDetails(id) {
    try {
        const response = await fetch(`/admin/testimonies/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            displayTestimonyDetails(data.testimony);
            document.getElementById('details-modal').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors du chargement des détails', 'error');
    }
}

function displayTestimonyDetails(testimony) {
    const content = document.getElementById('testimony-details-content');

    content.innerHTML = `
        <div class="space-y-6">
            <!-- Infos de base -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">ID</label>
                    <div class="text-sm text-gray-900">#${testimony.id}</div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Statut</label>
                    <div class="mt-1">${getStatusBadge(testimony.status)}</div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Catégorie</label>
                    <div class="mt-1">
                        <span class="px-2 py-1 text-xs rounded-full ${getCategoryColor(testimony.category)}">
                            ${getCategoryLabel(testimony.category)}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Vues</label>
                    <div class="text-sm text-gray-900">${testimony.views || 0}</div>
                </div>
            </div>

            <!-- Titre -->
            <div>
                <label class="text-sm font-medium text-gray-500">Titre</label>
                <div class="mt-1 text-base font-semibold text-gray-900">${escapeHtml(testimony.title)}</div>
            </div>

            <!-- Description -->
            <div>
                <label class="text-sm font-medium text-gray-500">Description</label>
                <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">${escapeHtml(testimony.description)}</div>
            </div>

            <!-- Localisation et date -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Localisation</label>
                    <div class="text-sm text-gray-900">${escapeHtml(testimony.location || 'Non spécifiée')}</div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Date de l'événement</label>
                    <div class="text-sm text-gray-900">${testimony.event_date ? formatDate(testimony.event_date) : 'Non spécifiée'}</div>
                </div>
            </div>

            <!-- Auteur -->
            <div>
                <label class="text-sm font-medium text-gray-500">Auteur</label>
                ${testimony.anonymous_publication ?
                    '<div class="text-sm text-gray-500 italic">Publication anonyme</div>' :
                    `<div class="text-sm text-gray-900">${escapeHtml(testimony.user?.prenom || '')} ${escapeHtml(testimony.user?.nom || '')}</div>
                    <div class="text-xs text-gray-500">${escapeHtml(testimony.user?.email || '')}</div>`
                }
            </div>

            <!-- Médias -->
            ${testimony.media_files && testimony.media_files.length > 0 ? `
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-500">Médias (${testimony.media_files.length})</label>
                        <a href="/admin/testimonies/${testimony.id}/download-all-media"
                           class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Télécharger tout (ZIP)
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        ${testimony.media_files.map(media => `
                            <div class="relative group">
                                ${media.is_video ?
                                    `<video src="/storage/${media.path}" class="w-full h-32 object-cover rounded" controls></video>` :
                                    `<img src="/storage/${media.path}" class="w-full h-32 object-cover rounded" />`
                                }
                                <button onclick="deleteMedia(${testimony.id}, '${media.path}')"
                                        class="absolute top-1 right-1 bg-red-600 text-white p-1 rounded opacity-0 group-hover:opacity-100 transition"
                                        title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <a href="/storage/${media.path}" download
                                   class="absolute bottom-1 right-1 bg-blue-600 text-white p-1 rounded opacity-0 group-hover:opacity-100 transition"
                                   title="Télécharger">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}

            <!-- Raison de rejet si applicable -->
            ${testimony.status === 'rejected' && testimony.rejection_reason ? `
                <div class="bg-red-50 border border-red-200 rounded p-4">
                    <label class="text-sm font-medium text-red-900 mb-2 block">Raison du rejet</label>
                    <div class="text-sm text-red-800">${escapeHtml(testimony.rejection_reason)}</div>
                </div>
            ` : ''}

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4 text-xs text-gray-500">
                <div>
                    <label class="font-medium">Créé le:</label>
                    <div>${formatDate(testimony.created_at)}</div>
                </div>
                ${testimony.validated_at ? `
                    <div>
                        <label class="font-medium">Validé le:</label>
                        <div>${formatDate(testimony.validated_at)}</div>
                    </div>
                ` : ''}
                ${testimony.published_at ? `
                    <div>
                        <label class="font-medium">Publié le:</label>
                        <div>${formatDate(testimony.published_at)}</div>
                    </div>
                ` : ''}
            </div>

            <!-- Actions -->
            <div class="flex gap-2 pt-4 border-t">
                ${testimony.status === 'pending' ? `
                    <button onclick="quickValidate(${testimony.id})" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Valider
                    </button>
                    <button onclick="showRejectModal(${testimony.id})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Rejeter
                    </button>
                ` : ''}
                ${testimony.status === 'validated' ? `
                    <button onclick="quickPublish(${testimony.id})" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                        Publier
                    </button>
                ` : ''}
                ${testimony.status === 'published' ? `
                    <button onclick="quickUnpublish(${testimony.id})" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Dépublier
                    </button>
                ` : ''}
                <button onclick="confirmDelete(${testimony.id})" class="ml-auto px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Supprimer
                </button>
            </div>
        </div>
    `;
}

function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
}

// Actions rapides
async function quickValidate(id) {
    if (!confirm('Voulez-vous vraiment valider ce témoignage ?')) return;

    try {
        const response = await fetch(`/admin/testimonies/${id}/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Témoignage validé avec succès', 'success');
            loadTestimonies(currentPage);
            closeDetailsModal();
        } else {
            showNotification(data.message || 'Erreur lors de la validation', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la validation', 'error');
    }
}

async function quickPublish(id) {
    if (!confirm('Voulez-vous vraiment publier ce témoignage ?')) return;

    try {
        const response = await fetch(`/admin/testimonies/${id}/publish`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Témoignage publié avec succès', 'success');
            loadTestimonies(currentPage);
            closeDetailsModal();
        } else {
            showNotification(data.message || 'Erreur lors de la publication', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la publication', 'error');
    }
}

async function quickUnpublish(id) {
    if (!confirm('Voulez-vous vraiment dépublier ce témoignage ?')) return;

    try {
        const response = await fetch(`/admin/testimonies/${id}/unpublish`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Témoignage dépublié avec succès', 'success');
            loadTestimonies(currentPage);
            closeDetailsModal();
        } else {
            showNotification(data.message || 'Erreur lors de la dépublication', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la dépublication', 'error');
    }
}

// Modal de rejet
function showRejectModal(id) {
    currentTestimonyId = id;
    document.getElementById('rejection-reason').value = '';
    document.getElementById('reject-modal').classList.remove('hidden');
    closeDetailsModal();
}

function showBulkRejectModal() {
    if (selectedIds.size === 0) {
        showNotification('Aucun témoignage sélectionné', 'warning');
        return;
    }
    currentTestimonyId = null;
    document.getElementById('rejection-reason').value = '';
    document.getElementById('reject-modal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    currentTestimonyId = null;
}

async function confirmReject() {
    const reason = document.getElementById('rejection-reason').value.trim();

    if (reason.length < 10) {
        showNotification('La raison du rejet doit contenir au moins 10 caractères', 'warning');
        return;
    }

    if (currentTestimonyId) {
        // Rejet individuel
        try {
            const response = await fetch(`/admin/testimonies/${currentTestimonyId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ rejection_reason: reason })
            });

            const data = await response.json();

            if (data.success) {
                showNotification('Témoignage rejeté avec succès', 'success');
                loadTestimonies(currentPage);
                closeRejectModal();
            } else {
                showNotification(data.message || 'Erreur lors du rejet', 'error');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showNotification('Erreur lors du rejet', 'error');
        }
    } else {
        // Rejet en masse
        bulkAction('reject', reason);
        closeRejectModal();
    }
}

// Suppression
async function confirmDelete(id) {
    if (!confirm('Voulez-vous vraiment supprimer ce témoignage ?')) return;

    try {
        const response = await fetch(`/admin/testimonies/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Témoignage supprimé avec succès', 'success');
            loadTestimonies(currentPage);
            closeDetailsModal();
        } else {
            showNotification(data.message || 'Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression', 'error');
    }
}

// Suppression de média
async function deleteMedia(testimonyId, mediaPath) {
    if (!confirm('Voulez-vous vraiment supprimer ce média ?')) return;

    try {
        const response = await fetch(`/admin/testimonies/${testimonyId}/media`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ media_path: mediaPath })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Média supprimé avec succès', 'success');
            showDetails(testimonyId);
        } else {
            showNotification(data.message || 'Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression du média', 'error');
    }
}

// Sélection multiple
function toggleSelection(id) {
    if (selectedIds.has(id)) {
        selectedIds.delete(id);
    } else {
        selectedIds.add(id);
    }
    updateBulkActionsBar();
}

function toggleSelectAll() {
    const checkbox = document.getElementById('select-all-checkbox');
    if (checkbox.checked) {
        testimonies.forEach(t => selectedIds.add(t.id));
    } else {
        selectedIds.clear();
    }
    updateBulkActionsBar();
    displayTestimonies();
}

function selectAll() {
    testimonies.forEach(t => selectedIds.add(t.id));
    document.getElementById('select-all-checkbox').checked = true;
    updateBulkActionsBar();
    displayTestimonies();
}

function deselectAll() {
    selectedIds.clear();
    document.getElementById('select-all-checkbox').checked = false;
    updateBulkActionsBar();
    displayTestimonies();
}

function updateBulkActionsBar() {
    const bulkBar = document.getElementById('bulk-actions');
    const count = document.getElementById('selected-count');

    if (selectedIds.size > 0) {
        bulkBar.classList.remove('hidden');
        count.textContent = selectedIds.size;
    } else {
        bulkBar.classList.add('hidden');
    }
}

// Actions en masse
async function bulkAction(action, rejectionReason = null) {
    if (selectedIds.size === 0) {
        showNotification('Aucun témoignage sélectionné', 'warning');
        return;
    }

    const actionLabels = {
        validate: 'valider',
        reject: 'rejeter',
        publish: 'publier',
        unpublish: 'dépublier',
        delete: 'supprimer'
    };

    const label = actionLabels[action] || action;

    if (!confirm(`Voulez-vous vraiment ${label} les ${selectedIds.size} témoignage(s) sélectionné(s) ?`)) {
        return;
    }

    try {
        const body = {
            action: action,
            ids: Array.from(selectedIds)
        };

        if (action === 'reject' && rejectionReason) {
            body.rejection_reason = rejectionReason;
        }

        const response = await fetch('/admin/testimonies/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        });

        const data = await response.json();

        if (data.success) {
            showNotification(data.message, 'success');
            selectedIds.clear();
            updateBulkActionsBar();
            loadTestimonies(currentPage);
        } else {
            showNotification(data.message || `Erreur lors de l'action en masse`, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification(`Erreur lors de l'action en masse`, 'error');
    }
}

function confirmBulkDelete() {
    if (selectedIds.size === 0) {
        showNotification('Aucun témoignage sélectionné', 'warning');
        return;
    }

    if (confirm(`⚠️ ATTENTION : Vous êtes sur le point de supprimer ${selectedIds.size} témoignage(s).\n\nCette action est irréversible. Continuer ?`)) {
        bulkAction('delete');
    }
}

// Tri
function sortBy(field) {
    if (currentFilters.sort_by === field) {
        currentFilters.sort_order = currentFilters.sort_order === 'asc' ? 'desc' : 'asc';
    } else {
        currentFilters.sort_by = field;
        currentFilters.sort_order = 'desc';
    }
    loadTestimonies(1);
}

// Filtres
function applyFilters() {
    currentFilters.search = document.getElementById('search').value;
    currentFilters.status = document.getElementById('filter-status').value;
    currentFilters.category = document.getElementById('filter-category').value;
    currentFilters.anonymous = document.getElementById('filter-anonymous').checked;
    loadTestimonies(1);
}

function resetFilters() {
    document.getElementById('search').value = '';
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-anonymous').checked = false;
    currentFilters = {
        search: '',
        status: '',
        category: '',
        anonymous: false,
        sort_by: 'created_at',
        sort_order: 'desc'
    };
    loadTestimonies(1);
}

// Mettre à jour les stats
function updateStats(stats) {
    document.getElementById('stat-total').textContent = stats.total || 0;
    document.getElementById('stat-pending').textContent = stats.pending || 0;
    document.getElementById('stat-validated').textContent = stats.validated || 0;
    document.getElementById('stat-rejected').textContent = stats.rejected || 0;
    document.getElementById('stat-published').textContent = stats.published || 0;
    document.getElementById('stat-anonymous').textContent = stats.anonymous || 0;
    document.getElementById('stat-views').textContent = stats.total_views || 0;
}

// Pagination
function updatePagination(paginationData) {
    document.getElementById('showing-from').textContent = paginationData.from || 0;
    document.getElementById('showing-to').textContent = paginationData.to || 0;
    document.getElementById('showing-total').textContent = paginationData.total || 0;

    const linksContainer = document.getElementById('pagination-links');
    const links = [];

    if (paginationData.current_page > 1) {
        links.push(`
            <button onclick="loadTestimonies(${paginationData.current_page - 1})"
                    class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                Précédent
            </button>
        `);
    }

    const maxPages = 5;
    let startPage = Math.max(1, paginationData.current_page - Math.floor(maxPages / 2));
    let endPage = Math.min(paginationData.last_page, startPage + maxPages - 1);

    if (endPage - startPage < maxPages - 1) {
        startPage = Math.max(1, endPage - maxPages + 1);
    }

    if (startPage > 1) {
        links.push(`
            <button onclick="loadTestimonies(1)"
                    class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                1
            </button>
        `);
        if (startPage > 2) {
            links.push('<span class="px-2">...</span>');
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        links.push(`
            <button onclick="loadTestimonies(${i})"
                    class="px-3 py-1 border ${i === paginationData.current_page ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 hover:bg-gray-50'} rounded">
                ${i}
            </button>
        `);
    }

    if (endPage < paginationData.last_page) {
        if (endPage < paginationData.last_page - 1) {
            links.push('<span class="px-2">...</span>');
        }
        links.push(`
            <button onclick="loadTestimonies(${paginationData.last_page})"
                    class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                ${paginationData.last_page}
            </button>
        `);
    }

    if (paginationData.current_page < paginationData.last_page) {
        links.push(`
            <button onclick="loadTestimonies(${paginationData.current_page + 1})"
                    class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                Suivant
            </button>
        `);
    }

    linksContainer.innerHTML = links.join('');
}

// Helpers
function getStatusBadge(status) {
    const badges = {
        pending: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>',
        validated: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>',
        rejected: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>',
        published: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Publié</span>'
    };
    return badges[status] || status;
}

function getCategoryColor(category) {
    const colors = {
        corruption: 'bg-red-100 text-red-800',
        injustice: 'bg-orange-100 text-orange-800',
        violence: 'bg-red-100 text-red-800',
        fraude: 'bg-pink-100 text-pink-800',
        environnement: 'bg-green-100 text-green-800',
        sante: 'bg-blue-100 text-blue-800',
        education: 'bg-indigo-100 text-indigo-800',
        autre: 'bg-gray-100 text-gray-800'
    };
    return colors[category] || 'bg-gray-100 text-gray-800';
}

function getCategoryLabel(category) {
    const labels = {
        corruption: 'Corruption',
        injustice: 'Injustice',
        violence: 'Violence',
        fraude: 'Fraude',
        environnement: 'Environnement',
        sante: 'Santé',
        education: 'Éducation',
        autre: 'Autre'
    };
    return labels[category] || category;
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Notifications
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };

    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('animate-slide-out');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    loadTestimonies();

    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => applyFilters(), 500);
    });

    document.getElementById('filter-status').addEventListener('change', applyFilters);
    document.getElementById('filter-category').addEventListener('change', applyFilters);
    document.getElementById('filter-anonymous').addEventListener('change', applyFilters);
});

// Animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slide-out {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out; }
    .animate-slide-out { animation: slide-out 0.3s ease-in; }
`;
document.head.appendChild(style);
</script>
@endpush
