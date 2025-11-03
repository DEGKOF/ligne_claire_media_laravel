@extends('layouts.admin')

@section('title', 'Dashboard Annonceur')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord Annonceur</h1>
        <p class="text-gray-600">Bienvenue {{ auth()->user()->company_name }}</p>
    </div>

    <!-- Statut du profil -->
    @if($profile->status === 'pending')
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Votre profil est en attente de validation.
                        <a href="{{ route('advertiser.profile.complete') }}" class="font-medium underline">
                            Compléter mon profil
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @elseif($profile->status === 'rejected')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Profil rejeté</h3>
                    <p class="mt-1 text-sm text-red-700">{{ $profile->rejection_reason }}</p>
                    <a href="{{ route('advertiser.profile.complete') }}" class="mt-2 inline-block text-sm font-medium text-red-700 underline">
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
    @elseif($profile->status === 'suspended')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Compte suspendu</h3>
                    <p class="mt-1 text-sm text-red-700">{{ $profile->rejection_reason }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Balance -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-md bg-green-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Solde</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['balance'], 0, ',', ' ') }} FCFA</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Campagnes actives -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-md bg-blue-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Campagnes actives</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['active_campaigns'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Impressions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-md bg-purple-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Impressions totales</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_impressions']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Clics -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-md bg-orange-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Clics totaux</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_clicks']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Actions rapides</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($profile->isActive())
                    <a href="{{ route('advertiser.campaigns.create') }}"
                       class="flex items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        {{-- <span class="text-3xl mr-4">➕</span> --}}
                        <div>
                            <p class="font-semibold text-gray-900">Nouvelle campagne</p>
                            <p class="text-sm text-gray-600">Créer une publicité</p>
                        </div>
                    </a>
                @endif

                <a href="{{ route('advertiser.campaigns.index') }}"
                   class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition">
                    {{-- <span class="text-3xl mr-4">📊</span> --}}
                    <div>
                        <p class="font-semibold text-gray-900">Mes campagnes</p>
                        <p class="text-sm text-gray-600">{{ $stats['total_campaigns'] }} campagnes</p>
                    </div>
                </a>

                <a href="#"
                   class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition">
                    {{-- <span class="text-3xl mr-4">💳</span> --}}
                    <div>
                        <p class="font-semibold text-gray-900">Recharger</p>
                        <p class="text-sm text-gray-600">Ajouter des crédits</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Campagnes récentes -->
    @if($recentCampaigns->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Campagnes récentes</h2>
            <a href="{{ route('advertiser.campaigns.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Voir tout →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campagne</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Emplacement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Impressions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clics</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CTR</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentCampaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $campaign->name }}</div>
                                <div class="text-xs text-gray-500">{{ $campaign->reference }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $campaign->placement->name }}</td>
                        <td class="px-6 py-4">{!! $campaign->status_badge !!}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($campaign->impressions_count) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($campaign->clicks_count) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $campaign->ctr }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
