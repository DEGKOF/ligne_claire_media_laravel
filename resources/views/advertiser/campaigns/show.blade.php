@extends('layouts.admin')

@section('title', $campaign->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">

    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $campaign->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $campaign->reference }}</p>
        </div>

        <div class="flex gap-2">
            @if($campaign->status === 'draft')
                <form action="{{ route('advertiser.campaigns.submit', $campaign) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Soumettre pour validation
                    </button>
                </form>
            @endif

            @if($campaign->status === 'active')
                <form action="{{ route('advertiser.campaigns.pause', $campaign) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Mettre en pause
                    </button>
                </form>
            @endif

            @if($campaign->status === 'paused')
                <form action="{{ route('advertiser.campaigns.resume', $campaign) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Reprendre
                    </button>
                </form>
            @endif

            @if(in_array($campaign->status, ['draft', 'rejected']))
                <a href="{{ route('advertiser.campaigns.edit', $campaign) }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Éditer
                </a>
            @endif

            <a href="{{ route('advertiser.campaigns.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                Retour
            </a>
        </div>
    </div>

    <!-- Statut et alertes -->
    @if($campaign->status === 'rejected')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <h3 class="text-sm font-medium text-red-800">Campagne rejetée</h3>
            <p class="mt-1 text-sm text-red-700">{{ $campaign->rejection_reason }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Aperçu -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Aperçu de la publicité</h2>

                @if($campaign->content_type === 'image' && $campaign->image_url)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <img src="{{ $campaign->image_url }}" alt="{{ $campaign->name }}" class="w-full">
                    </div>

                    @if($campaign->headline || $campaign->caption)
                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            @if($campaign->headline)
                                <h3 class="font-semibold text-lg">{{ $campaign->headline }}</h3>
                            @endif
                            @if($campaign->caption)
                                <p class="text-gray-600 mt-2">{{ $campaign->caption }}</p>
                            @endif
                            @if($campaign->cta_text)
                                <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">
                                    {{ $campaign->cta_text }}
                                </button>
                            @endif
                        </div>
                    @endif
                @endif

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        <strong>URL de destination :</strong>
                        <a href="{{ $campaign->target_url }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $campaign->target_url }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Stats détaillées -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistiques détaillées</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($campaign->impressions_count) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Impressions</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($campaign->clicks_count) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Clics</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ $campaign->ctr }}%</div>
                        <div class="text-sm text-gray-600 mt-1">CTR</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-3xl font-bold text-orange-600">{{ number_format($campaign->spent, 0, ',', ' ') }} F</div>
                        <div class="text-sm text-gray-600 mt-1">Dépensé</div>
                    </div>
                </div>

                @if($dailyStats->count() > 0)
                    <div>
                        <h3 class="font-semibold mb-3">Évolution (30 derniers jours)</h3>
                        <canvas id="statsChart" height="80"></canvas>
                    </div>
                @endif
            </div>

        </div>

        <!-- Colonne latérale -->
        <div class="space-y-6">

            <!-- Informations -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations</h2>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-600">Statut :</span>
                        <div class="mt-1">{!! $campaign->status_badge !!}</div>
                    </div>

                    <div>
                        <span class="text-gray-600">Emplacement :</span>
                        <div class="font-medium mt-1">{{ $campaign->placement->name }}</div>
                    </div>

                    <div>
                        <span class="text-gray-600">Période :</span>
                        <div class="font-medium mt-1">
                            Du {{ $campaign->start_date->format('d/m/Y') }}<br>
                            au {{ $campaign->end_date->format('d/m/Y') }}
                        </div>
                        @if($campaign->days_remaining >= 0)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $campaign->days_remaining }} jours restants
                            </div>
                        @endif
                    </div>

                    @if($campaign->budget)
                        <div>
                            <span class="text-gray-600">Budget :</span>
                            <div class="font-medium mt-1">{{ number_format($campaign->budget, 0, ',', ' ') }} FCFA</div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $campaign->budget_progress }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ number_format($campaign->budget - $campaign->spent, 0, ',', ' ') }} FCFA restants
                            </div>
                        </div>
                    @endif

                    @if($campaign->description)
                        <div>
                            <span class="text-gray-600">Description :</span>
                            <div class="text-gray-900 mt-1">{{ $campaign->description }}</div>
                        </div>
                    @endif

                    <div class="pt-3 border-t">
                        <span class="text-gray-600">Créée le :</span>
                        <div class="font-medium mt-1">{{ $campaign->created_at->format('d/m/Y à H:i') }}</div>
                    </div>

                    @if($campaign->approved_at)
                        <div>
                            <span class="text-gray-600">Approuvée le :</span>
                            <div class="font-medium mt-1">{{ $campaign->approved_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ciblage -->
            @if($campaign->target_devices || $campaign->target_pages || $campaign->target_rubriques)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ciblage</h2>

                    <div class="space-y-3 text-sm">
                        @if($campaign->target_devices)
                            <div>
                                <span class="text-gray-600">Appareils :</span>
                                <div class="flex gap-2 mt-1">
                                    @foreach($campaign->target_devices as $device)
                                        <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ ucfirst($device) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($campaign->target_pages)
                            <div>
                                <span class="text-gray-600">Pages :</span>
                                <div class="flex gap-2 mt-1 flex-wrap">
                                    @foreach($campaign->target_pages as $page)
                                        <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $page }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

@if($dailyStats->count() > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('statsChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyStats->pluck('date')) !!},
        datasets: [{
            label: 'Impressions',
            data: {!! json_encode($dailyStats->pluck('count')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush
@endif
@endsection
