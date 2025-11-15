@extends('layouts.frontend')

@section('title', $rubrique->name . ' - LIGNE CLAIRE MÉDIA+')
@section('meta_description', $rubrique->description)

@section('content')
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
                        class="h-96 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative">
                        @if ($featured->featured_image)
                            <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-9xl">{{ $rubrique->icon }}</span>
                        @endif
                        @if ($featured->is_new)
                            <span
                                class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">
                                NEW
                            </span>
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
                                class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                                @if ($publication->featured_image)
                                    <img src="{{ asset('storage/' . $publication->featured_image) }}"
                                        alt="{{ $publication->title }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-5xl">{{ $rubrique->icon }}</span>
                                @endif
                                @if ($publication->is_new)
                                    <span
                                        class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                                        NEW
                                    </span>
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
