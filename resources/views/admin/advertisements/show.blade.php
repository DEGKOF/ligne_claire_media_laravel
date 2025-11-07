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
                'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Brouillon'],
                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'En attente'],
                'approved' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Approuvée'],
                'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Active'],
                'paused' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'En pause'],
                'completed' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Terminée'],
                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Rejetée'],
                'expired' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Expirée'],
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
            <!-- Contenu publicitaire -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Contenu publicitaire</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        @switch($campaign->content_type)
                            @case('image') <i class="fas fa-image mr-1"></i> Image @break
                            @case('video') <i class="fas fa-video mr-1"></i> Vidéo @break
                            @case('html') <i class="fas fa-code mr-1"></i> HTML @break
                        @endswitch
                    </span>
                </div>

                @if($campaign->content_type === 'image')
                    <!-- Image -->
                    @if($campaign->image_path)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($campaign->image_path) }}" alt="{{ $campaign->name }}" class="w-full">
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <i class="fas fa-image text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">Aucune image</p>
                        </div>
                    @endif

                @elseif($campaign->content_type === 'video')
                    <!-- Vidéo -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-black">
                        @if($campaign->video_url)
                            <!-- Vidéo externe (YouTube, Vimeo, etc.) -->
                            @php
                                $isYoutube = str_contains($campaign->video_url, 'youtube.com') || str_contains($campaign->video_url, 'youtu.be');
                                $isVimeo = str_contains($campaign->video_url, 'vimeo.com');

                                if ($isYoutube) {
                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $campaign->video_url, $matches);
                                    $videoId = $matches[1] ?? null;
                                    $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : $campaign->video_url;
                                } elseif ($isVimeo) {
                                    preg_match('/vimeo\.com\/(\d+)/', $campaign->video_url, $matches);
                                    $videoId = $matches[1] ?? null;
                                    $embedUrl = $videoId ? "https://player.vimeo.com/video/{$videoId}" : $campaign->video_url;
                                } else {
                                    $embedUrl = $campaign->video_url;
                                }
                            @endphp

                            <div class="aspect-video">
                                <iframe src="{{ $embedUrl }}"
                                        class="w-full h-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 border-t">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-link mr-2"></i>
                                    <span class="font-medium mr-2">URL externe:</span>
                                    <a href="{{ $campaign->video_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 truncate">
                                        {{ $campaign->video_url }}
                                    </a>
                                </div>
                            </div>

                        @elseif($campaign->video_path)
                            <!-- Vidéo hébergée localement -->
                            <video controls class="w-full">
                                <source src="{{ Storage::url($campaign->video_path) }}" type="video/mp4">
                                Votre navigateur ne supporte pas la lecture de vidéos.
                            </video>

                            <div class="bg-gray-50 px-4 py-3 border-t">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-file-video mr-2"></i>
                                    <span class="font-medium mr-2">Fichier hébergé:</span>
                                    <span class="truncate">{{ basename($campaign->video_path) }}</span>
                                </div>
                            </div>

                        @else
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                                <i class="fas fa-video text-gray-400 text-4xl mb-3"></i>
                                <p class="text-gray-500">Aucune vidéo</p>
                            </div>
                        @endif
                    </div>

                @elseif($campaign->content_type === 'html')
                    <!-- Contenu HTML -->
                    @if($campaign->html_content)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 border-b flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Aperçu</span>
                                <button onclick="toggleHtmlCode()" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-code mr-1"></i>Voir le code
                                </button>
                            </div>
                            <div id="htmlPreview" class="p-4">
                                {!! $campaign->html_content !!}
                            </div>
                            <div id="htmlCode" class="hidden bg-gray-900 text-gray-100 p-4 overflow-x-auto">
                                <pre class="text-xs"><code>{{ $campaign->html_content }}</code></pre>
                            </div>
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <i class="fas fa-code text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">Aucun contenu HTML</p>
                        </div>
                    @endif
                @endif

                <!-- Informations supplémentaires du contenu -->
                @if($campaign->headline || $campaign->caption || $campaign->cta_text)
                    <div class="mt-6 space-y-3 pt-6 border-t">
                        @if($campaign->headline)
                            <div>
                                <div class="text-sm font-medium text-gray-600 mb-1">Titre</div>
                                <div class="text-gray-900">{{ $campaign->headline }}</div>
                            </div>
                        @endif

                        @if($campaign->caption)
                            <div>
                                <div class="text-sm font-medium text-gray-600 mb-1">Description</div>
                                <div class="text-gray-900">{{ $campaign->caption }}</div>
                            </div>
                        @endif

                        @if($campaign->cta_text)
                            <div>
                                <div class="text-sm font-medium text-gray-600 mb-1">Bouton d'action (CTA)</div>
                                <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                                    {{ $campaign->cta_text }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- URL de destination -->
                @if($campaign->target_url)
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-external-link-alt text-blue-600 mt-1"></i>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-600 mb-1">URL de destination</div>
                                <a href="{{ $campaign->target_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                                    {{ $campaign->target_url }}
                                </a>
                                @if($campaign->open_new_tab)
                                    <span class="ml-2 text-xs text-gray-500">(Nouvel onglet)</span>
                                @endif
                            </div>
                        </div>
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
                        @if($campaign->max_impressions)
                            <div class="text-xs text-gray-500 mt-1">sur {{ number_format($campaign->max_impressions) }} max</div>
                        @endif
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ number_format($campaign->clicks_count) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Clics</div>
                        @if($campaign->max_clicks)
                            <div class="text-xs text-gray-500 mt-1">sur {{ number_format($campaign->max_clicks) }} max</div>
                        @endif
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($campaign->ctr, 2) }}%</div>
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
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description de la campagne</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $campaign->description }}</p>
            </div>
            @endif

            <!-- Ciblage -->
            @if($campaign->target_rubriques || $campaign->target_pages || $campaign->target_devices || $campaign->target_cities || $campaign->target_days)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ciblage</h3>
                <div class="space-y-4">
                    @if($campaign->target_rubriques)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Rubriques ciblées</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($campaign->target_rubriques) as $rubriqueId)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                        Rubrique #{{ $rubriqueId }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($campaign->target_pages)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Pages ciblées</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($campaign->target_pages) as $page)
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                        {{ ucfirst($page) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($campaign->target_devices)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Appareils ciblés</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($campaign->target_devices) as $device)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                        <i class="fas fa-{{ $device === 'mobile' ? 'mobile-alt' : 'desktop' }} mr-1"></i>
                                        {{ ucfirst($device) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($campaign->target_cities)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Villes ciblées</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($campaign->target_cities) as $city)
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $city }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($campaign->target_days)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Jours de diffusion</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($campaign->target_days) as $day)
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                        {{ $day }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($campaign->target_time_start && $campaign->target_time_end)
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-2">Plage horaire</div>
                            <div class="text-gray-900">
                                <i class="fas fa-clock mr-2"></i>
                                De {{ \Carbon\Carbon::parse($campaign->target_time_start)->format('H:i') }}
                                à {{ \Carbon\Carbon::parse($campaign->target_time_end)->format('H:i') }}
                            </div>
                        </div>
                    @endif
                </div>
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
                                le {{ $campaign->approved_at ? \Carbon\Carbon::parse($campaign->approved_at)->format('d/m/Y à H:i') : '' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if(in_array($campaign->status, ['approved', 'active']) && $campaign->approver)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Campagne approuvée</h3>
                        <p class="text-sm text-gray-700">
                            Par {{ $campaign->approver->display_name ?? $campaign->approver->username }}
                            le {{ $campaign->approved_at ? \Carbon\Carbon::parse($campaign->approved_at)->format('d/m/Y à H:i') : '' }}
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
                        @if($campaign->is_permanent)
                            <div class="font-medium text-gray-900">
                                <i class="fas fa-infinity mr-1"></i>Permanente
                            </div>
                        @else
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
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Priorité</div>
                        <div class="font-medium text-gray-900">{{ $campaign->priority }}</div>
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
                            <span class="font-medium">{{ number_format($campaign->spent, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $percentage = $campaign->budget > 0 ? min(($campaign->spent / $campaign->budget) * 100, 100) : 0;
                            @endphp
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-sm text-gray-600">Budget total</span>
                        <span class="font-bold text-gray-900">{{ number_format($campaign->budget, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @if($campaign->daily_budget)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Budget journalier</span>
                            <span class="font-medium text-gray-900">{{ number_format($campaign->daily_budget, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Limites -->
            @if($campaign->max_impressions || $campaign->max_clicks || $campaign->max_daily_impressions || $campaign->max_daily_clicks)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Limites</h3>
                <div class="space-y-3">
                    @if($campaign->max_impressions)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Impressions max</span>
                            <span class="font-medium text-gray-900">{{ number_format($campaign->max_impressions) }}</span>
                        </div>
                    @endif
                    @if($campaign->max_clicks)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Clics max</span>
                            <span class="font-medium text-gray-900">{{ number_format($campaign->max_clicks) }}</span>
                        </div>
                    @endif
                    @if($campaign->max_daily_impressions)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Impressions/jour max</span>
                            <span class="font-medium text-gray-900">{{ number_format($campaign->max_daily_impressions) }}</span>
                        </div>
                    @endif
                    @if($campaign->max_daily_clicks)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Clics/jour max</span>
                            <span class="font-medium text-gray-900">{{ number_format($campaign->max_daily_clicks) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
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

function toggleHtmlCode() {
    const preview = document.getElementById('htmlPreview');
    const code = document.getElementById('htmlCode');

    if (preview.classList.contains('hidden')) {
        preview.classList.remove('hidden');
        code.classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        code.classList.remove('hidden');
    }
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
