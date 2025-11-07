@extends('layouts.admin')

@section('page-title', 'Détails de la campagne')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.advertisements.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $campaign->name }}</h2>
                <p class="text-sm text-gray-500">Référence: {{ $campaign->reference }}</p>
            </div>
        </div>

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
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $status['bg'] }} {{ $status['text'] }}">
            {{ $status['label'] }}
        </span>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-wrap gap-3">
            @if($campaign->status === 'pending')
                <button onclick="openApproveModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-check mr-2"></i>Approuver
                </button>
                <button onclick="openRejectModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-times mr-2"></i>Rejeter
                </button>
            @endif

            @if($campaign->status === 'approved')
                <form action="{{ route('admin.advertisements.activate', $campaign) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="return confirm('Activer cette campagne ?')">
                        <i class="fas fa-play mr-2"></i>Activer
                    </button>
                </form>
            @endif

            @if($campaign->status === 'active')
                <form action="{{ route('admin.advertisements.pause', $campaign) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition" onclick="return confirm('Mettre en pause cette campagne ?')">
                        <i class="fas fa-pause mr-2"></i>Mettre en pause
                    </button>
                </form>
            @endif

            @if($campaign->status === 'paused')
                <form action="{{ route('admin.advertisements.activate', $campaign) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="return confirm('Réactiver cette campagne ?')">
                        <i class="fas fa-play mr-2"></i>Réactiver
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Bannière publicitaire -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bannière publicitaire</h3>
                @if($campaign->banner_image)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($campaign->banner_image) }}" alt="{{ $campaign->name }}" class="w-full">
                    </div>
                    @if($campaign->click_url)
                        <a href="{{ $campaign->click_url }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mt-3">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            {{ $campaign->click_url }}
                        </a>
                    @endif
                @else
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                        <i class="fas fa-image text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">Aucune bannière</p>
                    </div>
                @endif
            </div>

            <!-- Statistiques de performance -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance</h3>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($campaign->impressions_count) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Impressions</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ number_format($campaign->clicks_count) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Clics</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">
                            {{ $campaign->impressions_count > 0 ? number_format(($campaign->clicks_count / $campaign->impressions_count) * 100, 2) : '0' }}%
                        </div>
                        <div class="text-sm text-gray-600 mt-1">CTR</div>
                    </div>
                </div>

                <!-- Graphique des impressions -->
                @if($dailyStats->isNotEmpty())
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Impressions des 30 derniers jours</h4>
                        <div class="h-64 flex items-end justify-between gap-1">
                            @php
                                $maxImpressions = $dailyStats->max('impressions');
                            @endphp
                            @foreach($dailyStats as $stat)
                                <div class="flex-1 flex flex-col items-center group relative">
                                    <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-colors"
                                         style="height: {{ $maxImpressions > 0 ? ($stat->impressions / $maxImpressions * 100) : 0 }}%">
                                    </div>
                                    <div class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($stat->date)->format('d/m') }}: {{ number_format($stat->impressions) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-2">
                            <span>{{ $dailyStats->first() ? \Carbon\Carbon::parse($dailyStats->first()->date)->format('d/m/Y') : '' }}</span>
                            <span>{{ $dailyStats->last() ? \Carbon\Carbon::parse($dailyStats->last()->date)->format('d/m/Y') : '' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-chart-line text-3xl mb-2"></i>
                        <p>Aucune donnée disponible</p>
                    </div>
                @endif
            </div>

            <!-- Description -->
            @if($campaign->description)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $campaign->description }}</p>
            </div>
            @endif

            <!-- Historique d'approbation -->
            @if($campaign->status === 'rejected' && $campaign->rejection_reason)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl mt-1"></i>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-red-900 mb-2">Campagne rejetée</h3>
                        <p class="text-gray-700">{{ $campaign->rejection_reason }}</p>
                        @if($campaign->approver)
                            <p class="text-sm text-gray-600 mt-2">
                                Par {{ $campaign->approver->display_name ?? $campaign->approver->username }}
                                le {{ $campaign->reviewed_at ? \Carbon\Carbon::parse($campaign->reviewed_at)->format('d/m/Y à H:i') : '' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($campaign->status === 'approved' && $campaign->approver)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Campagne approuvée</h3>
                        <p class="text-sm text-gray-700">
                            Par {{ $campaign->approver->display_name ?? $campaign->approver->username }}
                            le {{ $campaign->reviewed_at ? \Carbon\Carbon::parse($campaign->reviewed_at)->format('d/m/Y à H:i') : '' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Colonne latérale -->
        <div class="space-y-6">
            <!-- Informations de l'annonceur -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Annonceur</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-600">Entreprise</div>
                        <div class="font-medium text-gray-900">{{ $campaign->advertiser->company_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Contact</div>
                        <div class="text-gray-900">{{ $campaign->advertiser->display_name ?? $campaign->advertiser->username }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Email</div>
                        <a href="mailto:{{ $campaign->advertiser->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $campaign->advertiser->email }}
                        </a>
                    </div>
                    @if($campaign->advertiser->advertiserProfile)
                        @if($campaign->advertiser->advertiserProfile->phone)
                        <div>
                            <div class="text-sm text-gray-600">Téléphone</div>
                            <div class="text-gray-900">{{ $campaign->advertiser->advertiserProfile->phone }}</div>
                        </div>
                        @endif
                        @if($campaign->advertiser->advertiserProfile->website)
                        <div>
                            <div class="text-sm text-gray-600">Site web</div>
                            <a href="{{ $campaign->advertiser->advertiserProfile->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ $campaign->advertiser->advertiserProfile->website }}
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Détails de la campagne -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-600">Emplacement</div>
                        <div class="font-medium text-gray-900">{{ $campaign->placement->name }}</div>
                        @if($campaign->placement->width && $campaign->placement->height)
                            <div class="text-sm text-gray-500">{{ $campaign->placement->width }} × {{ $campaign->placement->height }}px</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Type de facturation</div>
                        <div class="font-medium text-gray-900">
                            @switch($campaign->placement->billing_type)
                                @case('flat') Forfaitaire @break
                                @case('cpm') CPM (par 1000 impressions) @break
                                @case('cpc') CPC (par clic) @break
                                @default {{ $campaign->placement->billing_type }}
                            @endswitch
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Période</div>
                        <div class="font-medium text-gray-900">
                            Du {{ \Carbon\Carbon::parse($campaign->start_date)->format('d/m/Y') }}
                            <br>
                            Au {{ \Carbon\Carbon::parse($campaign->end_date)->format('d/m/Y') }}
                        </div>
                        @php
                            $daysRemaining = \Carbon\Carbon::parse($campaign->end_date)->diffInDays(now(), false);
                        @endphp
                        @if($campaign->status === 'active' && $daysRemaining < 0)
                            <div class="text-sm text-orange-600 mt-1">
                                {{ abs($daysRemaining) }} jour(s) restant(s)
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Budget</div>
                        <div class="font-medium text-gray-900">{{ number_format($campaign->budget, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Créée le</div>
                        <div class="text-gray-900">{{ $campaign->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Budget et dépenses -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Budget</h3>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Dépensé</span>
                            <span class="font-medium">{{ number_format($campaign->spent_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $percentage = $campaign->budget > 0 ? min(($campaign->spent_amount ?? 0) / $campaign->budget * 100, 100) : 0;
                            @endphp
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-sm text-gray-600">Budget total</span>
                        <span class="font-bold text-gray-900">{{ number_format($campaign->budget, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>
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
            <p class="text-sm text-gray-500 text-center mb-6">{{ $campaign->name }}</p>

            <form action="{{ route('admin.advertisements.approve', $campaign) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="flex gap-3">
                    <button type="button" onclick="closeApproveModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
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
            <p class="text-sm text-gray-500 text-center mb-6">{{ $campaign->name }}</p>

            <form action="{{ route('admin.advertisements.reject', $campaign) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                    <textarea name="reason" rows="4" required maxlength="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Expliquez pourquoi cette campagne est rejetée..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maximum 500 caractères</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
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
function openApproveModal() {
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

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
