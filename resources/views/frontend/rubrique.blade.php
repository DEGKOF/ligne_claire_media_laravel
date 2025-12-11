@extends('layouts.frontend')

@section('title', $rubrique->name . ' - LIGNE CLAIRE MÉDIA+')
@section('meta_description', $rubrique->description)

@section('content')
    <style>
        /* Overlay Play Button pour vidéos */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            opacity: 1;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 5;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .play-button svg {
            width: 24px;
            height: 24px;
            color: #1e3a8a;
            margin-left: 4px;
        }

        .video-container:hover .video-overlay {
            opacity: 1;
        }

        .video-container:hover .play-button {
            transform: scale(1.1);
        }

        /* Badge VIDEO */
        .video-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(220, 38, 38, 0.95);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 4px;
            z-index: 10;
        }

        /* Play button plus grand pour featured article */
        .featured-play-button {
            width: 80px;
            height: 80px;
        }

        .featured-play-button svg {
            width: 32px;
            height: 32px;
        }
    </style>

    <div class="bg-gradient-to-br from-blue-900 to-blue-600 py-16 mb-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <span class="text-9xl absolute right-12 top-1/2 -translate-y-1/2">{{ $rubrique->icon }}</span>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-5xl md:text-6xl font-black text-white uppercase mb-4">
                {{ $rubrique->name }}
            </h1>
            <p class="text-xl text-blue-100">
                {{ $rubrique->description }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-12">
        @if ($publications->isEmpty())
            <div class="text-center py-16">
                <p class="text-2xl text-gray-600">Aucun article pour le moment dans cette rubrique.</p>
            </div>
        @else
            <!-- Featured Article -->
            @php $featured = $publications->first(); @endphp
            <article class="bg-white rounded-xl shadow-2xl overflow-hidden mb-12 hover:shadow-3xl transition">
                <a href="{{ route('publication.show', $featured->slug) }}">
                    <div
                        class="h-96 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative video-container">
                        @if ($featured->featured_image)
                            @php
                                $extension = pathinfo($featured->featured_image, PATHINFO_EXTENSION);
                                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                            @endphp

                            @if ($isVideo)
                                <video autoplay muted loop class="w-full h-full object-cover" muted>
                                    <source src="{{ asset('storage/' . $featured->featured_image) }}"
                                        type="video/{{ $extension }}">
                                </video>
                                <!-- Badge VIDEO -->
                                <span class="video-badge">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                    VIDÉO
                                </span>
                                <!-- Play Button Overlay (plus grand) -->
                                <div class="video-overlay">
                                    <div class="play-button featured-play-button">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                                    class="w-full h-full object-cover">
                            @endif
                        @else
                            <span class="text-white text-9xl">{{ $rubrique->icon }}</span>
                        @endif
                        {{-- @if ($featured->is_new)
                            <span
                                class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">
                                NEW
                            </span>
                        @endif --}}

                        @if ($featured->published_at && $featured->published_at->gt(now()->subHours(12)))
                            <span class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">NEW</span>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4">
                                {{ $featured->title }}
                            </h2>
                            <div class="flex gap-6 text-white/90 text-sm">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $featured->user->public_name }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $featured->published_at->diffForHumans() }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ number_format($featured->views_count) }} vues
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>

            <!-- Other Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach ($publications->skip(1) as $publication)
                    <article
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition cursor-pointer">
                        <a href="{{ route('publication.show', $publication->slug) }}">
                            <div
                                class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative video-container">
                                @if ($publication->featured_image)
                                    @php
                                        $extension = pathinfo($publication->featured_image, PATHINFO_EXTENSION);
                                        $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                                    @endphp

                                    @if ($isVideo)
                                        <video autoplay muted loop class="w-full h-full object-cover" muted>
                                            <source src="{{ asset('storage/' . $publication->featured_image) }}"
                                                type="video/{{ $extension }}">
                                        </video>
                                        <!-- Badge VIDEO -->
                                        <span class="video-badge">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                            VIDÉO
                                        </span>
                                        <!-- Play Button Overlay -->
                                        <div class="video-overlay">
                                            <div class="play-button">
                                                <svg fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $publication->featured_image) }}"
                                            alt="{{ $publication->title }}" class="w-full h-full object-cover">
                                    @endif
                                @else
                                    <span class="text-white text-5xl">{{ $rubrique->icon }}</span>
                                @endif
                                {{-- @if ($publication->is_new)
                                    <span
                                        class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                                        NEW
                                    </span>
                                @endif --}}

                                @if ($publication->published_at && $publication->published_at->gt(now()->subHours(12)))
                                    <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">NEW</span>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold mb-3 leading-tight line-clamp-1 hover:text-blue-600 transition">
                                    {{ $publication->title }}
                                </h3>
                                @if ($publication->excerpt)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $publication->excerpt }}
                                    </p>
                                @endif
                                <div class="flex justify-between items-center text-xs text-gray-500 pt-4 border-t">
                                    <span class="flex">
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $publication->published_at->diffForHumans() }}
                                    </span>
                                    {{-- <span>💬 {{ $publication->comments_count }}</span> --}}
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        {{ $publication->comments_count }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $publications->links() }}
            </div>
        @endif
    </div>
@endsection
