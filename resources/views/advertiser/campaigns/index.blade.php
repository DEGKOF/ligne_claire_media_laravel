@extends('layouts.admin')

@section('title', 'Mes campagnes')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mes campagnes publicitaires</h1>
            <p class="text-gray-600 mt-1">Gérez vos campagnes et consultez les statistiques</p>
        </div>
        @if(auth()->user()->advertiserProfile->isActive())
            <a href="{{ route('advertiser.campaigns.create') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                {{-- <span>➕</span> --}}
                <span>Nouvelle campagne</span>
            </a>
        @endif
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Rechercher par nom ou référence..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>En pause</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetée</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                Filtrer
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('advertiser.campaigns.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Liste des campagnes -->
    @if($campaigns->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campagne</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Emplacement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($campaigns as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($campaign->image_url)
                                        <img src="{{ $campaign->image_url }}" alt="" class="w-12 h-12 object-cover rounded">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $campaign->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $campaign->reference }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $campaign->placement->name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div>{{ $campaign->start_date->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">au {{ $campaign->end_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>{{ number_format($campaign->budget, 0, ',', ' ') }} F</div>
                                <div class="text-xs text-gray-500">Dépensé: {{ number_format($campaign->spent, 0, ',', ' ') }} F</div>
                                @if($campaign->budget > 0)
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $campaign->budget_progress }}%"></div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>{{ number_format($campaign->impressions_count) }} vues</div>
                                <div>{{ number_format($campaign->clicks_count) }} clics</div>
                                <div class="text-xs text-gray-500">CTR: {{ $campaign->ctr }}%</div>
                            </td>
                            <td class="px-6 py-4">{!! $campaign->status_badge !!}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('advertiser.campaigns.show', $campaign) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        Voir
                                    </a>
                                    @if(in_array($campaign->status, ['draft', 'rejected']))
                                        <a href="{{ route('advertiser.campaigns.edit', $campaign) }}"
                                           class="text-gray-600 hover:text-gray-800 text-sm">
                                            Éditer
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $campaigns->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📢</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune campagne</h3>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore créé de campagne publicitaire.</p>
            @if(auth()->user()->advertiserProfile->isActive())
                <a href="{{ route('advertiser.campaigns.create') }}"
                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    Créer ma première campagne
                </a>
            @endif
        </div>
    @endif

</div>
@endsection
