@extends('layouts.frontend')

@section('title', 'LCM TÉMOINS — Vous êtes nos yeux, nos oreilles, notre vérité')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Fil d'Ariane --}}
    <nav class="text-sm mb-6">
        <a href="{{ route('witness.index') }}" class="text-blue-600 hover:underline">Témoignages</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600">{{ $testimony->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Contenu principal --}}
        <div class="lg:col-span-2">
            {{-- En-tête --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-4">
                    {{ $testimony->category }}
                </span>

                <h1 class="text-3xl font-bold mb-4">{{ $testimony->title }}</h1>

                <div class="flex items-center text-gray-600 text-sm space-x-4 mb-4">
                    @if(!$testimony->anonymous_publication && $testimony->user)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            {{ $testimony->user->prenom }} {{ $testimony->user->nom }}
                        </span>
                    @endif

                    @if($testimony->location)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $testimony->location }}
                        </span>
                    @endif

                    <span>{{ $testimony->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            {{-- Galerie de médias --}}
            @if($testimony->media_count > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">
                    Médias ({{ $testimony->media_count }})
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($testimony->all_media as $index => $media)
                        <div class="relative group">
                            @if($media['is_video'])
                                <video controls class="w-full h-64 object-cover rounded-lg">
                                    <source src="{{ Storage::url($media['path']) }}" type="{{ $media['type'] }}">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                            @else
                                <a href="{{ Storage::url($media['path']) }}"
                                target="_blank"
                                   data-lightbox="testimony-{{ $testimony->id }}"
                                   data-title="{{ $testimony->title }}">
                                    <img src="{{ Storage::url($media['path']) }}"
                                         alt="Média {{ $index + 1 }}"
                                         class="w-full h-64 object-cover rounded-lg hover:opacity-90 transition">

                                    {{-- Overlay au survol --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center rounded-lg">
                                        <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </a>
                            @endif

                            {{-- Numéro du média --}}
                            <span class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs">
                                {{ $index + 1 }} / {{ $testimony->media_count }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Description --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Description</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($testimony->description)) !!}
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Témoignages similaires --}}
            @if($relatedTestimonies->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Témoignages similaires</h3>

                <div class="space-y-4">
                    @foreach($relatedTestimonies as $related)
                    <a href="{{ route('witness.show', $related) }}"
                       class="block hover:bg-gray-50 p-3 rounded transition">
                        <div class="flex space-x-3">
                            @if($related->first_media)
                                <img src="{{ Storage::url($related->first_media['path']) }}"
                                     alt="{{ $related->title }}"
                                     class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-semibold text-sm line-clamp-2 mb-1">{{ $related->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $related->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Ajouter Lightbox2 pour la galerie d'images --}}
{{-- @push('styles') --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
{{-- @endpush --}}

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush
@endsection
