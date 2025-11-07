@extends('layouts.admin')

@section('page-title', 'Gestion des Campagnes Publicitaires')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">En attente</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Actives</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Impressions totales</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($stats['total_impressions']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Clics totaux</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($stats['total_clicks']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-mouse-pointer text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.advertisements.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Nom, référence, annonceur..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvée</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>En pause</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>

                <!-- Placement Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emplacement</label>
                    <select name="placement_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les emplacements</option>
                        @foreach($placements as $placement)
                            <option value="{{ $placement->id }}" {{ request('placement_id') == $placement->id ? 'selected' : '' }}>
                                {{ $placement->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.advertisements.placements.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-map-marker-alt mr-2"></i>
                Gérer les emplacements publicitaires
            </a>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campagne</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonceur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Emplacement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($campaign->banner_image)
                                    <img src="{{ Storage::url($campaign->banner_image) }}"
                                         alt="{{ $campaign->name }}"
                                         class="w-16 h-12 object-cover rounded mr-3">
                                @else
                                    <div class="w-16 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-900">{{ $campaign->name }}</div>
                                    <div class="text-sm text-gray-500">Réf: {{ $campaign->reference }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $campaign->advertiser->company_name }}</div>
                            <div class="text-sm text-gray-500">{{ $campaign->advertiser->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $campaign->placement->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div>{{ \Carbon\Carbon::parse($campaign->start_date)->format('d/m/Y') }}</div>
                            <div class="text-gray-500">{{ \Carbon\Carbon::parse($campaign->end_date)->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center text-gray-900">
                                <i class="fas fa-eye text-blue-500 mr-1"></i>
                                {{ number_format($campaign->impressions_count) }}
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-mouse-pointer text-purple-500 mr-1"></i>
                                {{ number_format($campaign->clicks_count) }}
                                @if($campaign->impressions_count > 0)
                                    <span class="ml-2 text-xs">({{ number_format(($campaign->clicks_count / $campaign->impressions_count) * 100, 2) }}%)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'En attente'],
                                    'approved' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Approuvée'],
                                    'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Active'],
                                    'paused' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'En pause'],
                                    'completed' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Terminée'],
                                    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Rejetée'],
                                ];
                                $status = $statusConfig[$campaign->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $campaign->status];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.advertisements.show', $campaign) }}"
                               class="text-blue-600 hover:text-blue-900"
                               title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($campaign->status === 'pending')
                                <button onclick="openApproveModal({{ $campaign->id }}, '{{ $campaign->name }}')"
                                        class="text-green-600 hover:text-green-900"
                                        title="Approuver">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="openRejectModal({{ $campaign->id }}, '{{ $campaign->name }}')"
                                        class="text-red-600 hover:text-red-900"
                                        title="Rejeter">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif

                            @if($campaign->status === 'approved')
                                <form action="{{ route('admin.advertisements.activate', $campaign) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-900"
                                            title="Activer"
                                            onclick="return confirm('Activer cette campagne ?')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                            @endif

                            @if($campaign->status === 'active')
                                <form action="{{ route('admin.advertisements.pause', $campaign) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-orange-600 hover:text-orange-900"
                                            title="Mettre en pause"
                                            onclick="return confirm('Mettre en pause cette campagne ?')">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-ad text-4xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium">Aucune campagne trouvée</p>
                            <p class="text-sm mt-2">Les campagnes publicitaires apparaîtront ici.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($campaigns->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal d'approbation -->
<div id="approveModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                <i class="fas fa-check text-green-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-4">Approuver la campagne</h3>
            <p class="text-sm text-gray-500 text-center mb-6" id="approveCampaignName"></p>

            <form id="approveForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeApproveModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Approuver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-times text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-4">Rejeter la campagne</h3>
            <p class="text-sm text-gray-500 text-center mb-6" id="rejectCampaignName"></p>

            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                    <textarea name="reason"
                              rows="4"
                              required
                              maxlength="500"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Expliquez pourquoi cette campagne est rejetée..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maximum 500 caractères</p>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeRejectModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Rejeter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openApproveModal(campaignId, campaignName) {
    document.getElementById('approveCampaignName').textContent = campaignName;
    document.getElementById('approveForm').action = `/admin/advertisements/${campaignId}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function openRejectModal(campaignId, campaignName) {
    document.getElementById('rejectCampaignName').textContent = campaignName;
    document.getElementById('rejectForm').action = `/admin/advertisements/${campaignId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Fermer les modals en cliquant en dehors
window.onclick = function(event) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');

    if (event.target === approveModal) {
        closeApproveModal();
    }
    if (event.target === rejectModal) {
        closeRejectModal();
    }
}
</script>
@endpush
