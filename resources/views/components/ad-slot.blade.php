@php
    // Définir les classes selon la position
    $containerClasses = match($position) {
        'sidebar' => 'max-w-sm',
        'banner_top' => 'max-w-7xl mx-auto',
        'banner_bottom' => 'max-w-7xl mx-auto',
        'popup' => 'max-w-lg',
        'article' => 'max-w-4xl mx-auto',
        default => 'max-w-2xl'
    };

    $isPopup = $position === 'popup';
@endphp

@if($ad)
    <div class="advertisement-container {{ $containerClasses }} relative group"
         data-ad-id="{{ $ad->id }}"
         data-position="{{ $position }}">

        <!-- Badge "Publicité" -->
        <div class="flex items-center justify-between mb-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-50 border border-gray-200 rounded-full text-[10px] font-semibold text-gray-500 uppercase tracking-wider shadow-sm">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9a1 1 0 012 0v4a1 1 0 11-2 0V9zm1-4a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
                Sponsorisé
            </span>
        </div>

        <!-- Conteneur principal avec effet -->
        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 bg-white border border-gray-100 {{ $isPopup ? 'animate-fade-in' : '' }}">

            @if($ad->content_type === 'image')
                <a href="{{ route('ad.track.click', $ad->id) }}"
                   target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                   rel="noopener noreferrer sponsored"
                   class="block relative overflow-hidden group">

                    <!-- Image avec effet hover -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $ad->image_url }}"
                             alt="{{ $ad->headline ?? 'Publicité' }}"
                             class="w-full h-auto transform group-hover:scale-105 transition-transform duration-500">

                        <!-- Overlay gradient au survol -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Badge CTA flottant -->
                        @if($ad->cta_text)
                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-sm font-bold text-gray-900 shadow-lg">
                                    {{ $ad->cta_text }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Texte de la publicité -->
                    @if($ad->headline || $ad->caption)
                        <div class="p-5 bg-gradient-to-b from-white to-gray-50">
                            @if($ad->headline)
                                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $ad->headline }}
                                </h3>
                            @endif
                            @if($ad->caption)
                                <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                                    {{ $ad->caption }}
                                </p>
                            @endif

                            <!-- Indicateur de lien -->
                            <div class="flex items-center gap-2 mt-3 text-blue-600 font-semibold text-sm">
                                <span>En savoir plus</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                </a>

            @elseif($ad->content_type === 'video')
                <div class="video-ad-container">
                    <!-- Conteneur vidéo responsive -->
                    <div class="relative pb-[56.25%] bg-gray-900">
                        <iframe src="{{ $ad->video_url }}"
                                frameborder="0"
                                allowfullscreen
                                class="absolute inset-0 w-full h-full"></iframe>
                    </div>

                    <!-- Zone de contenu -->
                    <div class="p-5 bg-gradient-to-b from-white to-gray-50">
                        @if($ad->headline)
                            <h3 class="font-bold text-lg text-gray-900 mb-2">
                                {{ $ad->headline }}
                            </h3>
                        @endif
                        @if($ad->caption)
                            <p class="text-sm text-gray-600 mb-4">
                                {{ $ad->caption }}
                            </p>
                        @endif

                        <!-- Bouton CTA -->
                        <a href="{{ route('ad.track.click', $ad->id) }}"
                           target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                           class="inline-flex items-center gap-2 w-full justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <span>{{ $ad->cta_text ?? 'En savoir plus' }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>

            @elseif($ad->content_type === 'html')
                <div class="html-ad-container p-5 bg-white">
                    {!! $ad->html_content !!}
                    <a href="{{ route('ad.track.click', $ad->id) }}"
                       target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                       style="display: none;"
                       aria-hidden="true">Track</a>
                </div>
            @endif

            <!-- Effet de bordure animé -->
            <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-blue-400/50 transition-all duration-300 pointer-events-none"></div>
        </div>

        <!-- Footer discret -->
        <div class="flex items-center justify-between mt-2 px-1">
            <span class="text-[10px] text-gray-400 uppercase tracking-wide">Contenu sponsorisé</span>
            @if($ad->advertiser_name ?? false)
                <span class="text-[10px] text-gray-400">Par {{ $ad->advertiser_name }}</span>
            @endif
        </div>
    </div>

@elseif($fallback)
    <!-- Version Fallback élégante -->
    <div class="advertisement-fallback {{ $containerClasses }} relative">
        <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gradient-to-br from-gray-50 to-white p-8 text-center shadow-inner">
            <!-- Icône décorative -->
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>

            <!-- Contenu fallback -->
            <div class="space-y-3">
                {!! $fallback !!}
            </div>

            <!-- Message promotionnel -->
            <p class="mt-4 text-xs text-gray-400 italic">
                Espace publicitaire disponible
            </p>
        </div>
    </div>
@endif

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }

    /* Limiter le nombre de lignes */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Animation du badge CTA */
    @keyframes pulse-shadow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(59, 130, 246, 0);
        }
    }

    .advertisement-container:hover .cta-badge {
        animation: pulse-shadow 2s infinite;
    }
</style>
