@extends('layouts.frontend')

@section('title', $proposal->title . ' - Investigation')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Breadcrumb --}}
                <nav class="mb-6 text-sm">
                    <ol class="flex items-center gap-2 text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-red-600">Accueil</a></li>
                        <li>/</li>
                        <li><a href="{{ route('investigation.index') }}" class="hover:text-red-600">Investigation</a></li>
                        <li>/</li>
                        <li class="text-gray-900 truncate">{{ Str::limit($proposal->title, 50) }}</li>
                    </ol>
                </nav>

                {{-- Main Card --}}
                <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                    {{-- Header --}}
                    <div class="p-6 border-b bg-gradient-to-r from-red-50 to-white">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                                {{ $proposal->theme }}
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                {{ $proposal->format }}
                            </span>
                            @if($proposal->status === 'validated')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                    ✓ Validé
                                </span>
                            @elseif($proposal->status === 'in_progress')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">
                                    En cours
                                </span>
                            @elseif($proposal->status === 'completed')
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                                    Terminé
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $proposal->title }}
                        </h1>

                        <div class="flex items-center gap-4 text-gray-600">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($proposal->user->prenom, 0, 1) }}{{ substr($proposal->user->nom, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $proposal->user->prenom }} {{ $proposal->user->nom }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Investigateur
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm">
                                Proposé {{ $proposal->created_at->diffForHumans() }}
                            </div>
                            @if($proposal->estimated_weeks)
                                <div class="text-sm">
                                    {{ $proposal->estimated_weeks }} semaines estimées
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 space-y-6">
                        {{-- Angle d'investigation --}}
                        <section>
                            <h2 class="text-xl font-bold mb-3 flex items-center gap-2">
                                {{-- <span class="text-red-600">🎯</span> --}}
                                Angle d'investigation
                            </h2>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! nl2br(e($proposal->angle)) !!}
                            </div>
                        </section>

                        {{-- Sources disponibles --}}
                        @if($proposal->sources)
                        <section class="border-t pt-6">
                            <h2 class="text-xl font-bold mb-3 flex items-center gap-2">
                                {{-- <span class="text-red-600">📚</span> --}}
                                Sources disponibles
                            </h2>
                            <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                                {!! nl2br(e($proposal->sources)) !!}
                            </div>
                        </section>
                        @endif

                        {{-- Besoins spécifiques --}}
                        @if($proposal->needs)
                        <section class="border-t pt-6">
                            <h2 class="text-xl font-bold mb-3 flex items-center gap-2">
                                {{-- <span class="text-red-600">🛠️</span> --}}
                                Besoins spécifiques
                            </h2>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! nl2br(e($proposal->needs)) !!}
                            </div>
                        </section>
                        @endif

                        {{-- Documents joints --}}
                        @if(!empty($proposal->files) && count($proposal->files) > 0)
                        <section class="border-t pt-6">
                            <h2 class="text-xl font-bold mb-3 flex items-center gap-2">
                                <span class="text-red-600">📎</span>
                                Documents joints
                            </h2>
                            <div class="space-y-2">
                                @foreach($proposal->files as $file)
                                <a href="{{ asset('storage/' . $file['path']) }}"
                                   target="_blank"
                                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="w-10 h-10 bg-red-100 rounded flex items-center justify-center">
                                        @if(str_contains($file['type'], 'pdf'))
                                            📄
                                        @elseif(str_contains($file['type'], 'image'))
                                            🖼️
                                        @else
                                            📁
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $file['name'] }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ number_format($file['size'] / 1024, 2) }} KB
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                                @endforeach
                            </div>
                        </section>
                        @endif

                        {{-- Timeline --}}
                        @if($proposal->validated_at || $proposal->started_at || $proposal->completed_at)
                        <section class="border-t pt-6">
                            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                                <span class="text-red-600">⏳</span>
                                Timeline
                            </h2>
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <div class="w-0.5 h-full bg-gray-300"></div>
                                    </div>
                                    <div class="pb-4">
                                        <div class="font-medium">Proposition soumise</div>
                                        <div class="text-sm text-gray-500">{{ $proposal->created_at->format('d/m/Y à H:i') }}</div>
                                    </div>
                                </div>

                                @if($proposal->validated_at)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        @if($proposal->started_at || $proposal->completed_at)
                                            <div class="w-0.5 h-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <div class="pb-4">
                                        <div class="font-medium">Proposition validée</div>
                                        <div class="text-sm text-gray-500">{{ $proposal->validated_at->format('d/m/Y à H:i') }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($proposal->started_at)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        @if($proposal->completed_at)
                                            <div class="w-0.5 h-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <div class="pb-4">
                                        <div class="font-medium">Investigation démarrée</div>
                                        <div class="text-sm text-gray-500">{{ $proposal->started_at->format('d/m/Y à H:i') }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($proposal->completed_at)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                    </div>
                                    <div>
                                        <div class="font-medium">Investigation terminée</div>
                                        <div class="text-sm text-gray-500">{{ $proposal->completed_at->format('d/m/Y à H:i') }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </section>
                        @endif
                    </div>
                </article>

                {{-- Comments Section (Optional) --}}
                <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">💬 Discussion</h2>
                    <p class="text-gray-500 text-center py-8">
                        Les commentaires seront bientôt disponibles
                    </p>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Budget Card --}}
                @if($proposal->budget && $proposal->budget > 0)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 sticky top-4">
                    <h3 class="text-lg font-bold mb-4">💰 Financement</h3>

                    <div class="mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-2xl font-bold text-red-600">
                                {{ number_format($proposal->budget_collected, 0, ',', ' ') }}
                            </span>
                            <span class="text-gray-500">
                                / {{ number_format($proposal->budget, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-red-600 h-3 rounded-full transition-all"
                                 style="width: {{ $proposal->budget_progress }}%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-2">
                            {{ $proposal->budget_progress }}% financé
                        </div>
                    </div>

                    @if($proposal->status === 'validated' && $proposal->budget_progress < 100)
                    <button class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        Soutenir ce projet
                    </button>
                    @elseif($proposal->budget_progress >= 100)
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-center">
                        ✅ Objectif atteint !
                    </div>
                    @endif

                    <div class="mt-4 pt-4 border-t space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Restant</span>
                            <span class="font-semibold">
                                {{ number_format($proposal->budget - $proposal->budget_collected, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                        @if($proposal->estimated_weeks)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durée estimée</span>
                            <span class="font-semibold">{{ $proposal->estimated_weeks }} semaines</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Share Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">📢 Partager</h3>
                    <div class="flex gap-2">
                        <button onclick="shareOnFacebook()"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                            Facebook
                        </button>
                        <button onclick="shareOnTwitter()"
                                class="flex-1 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition text-sm">
                            Twitter
                        </button>
                        <button onclick="shareOnWhatsApp()"
                                class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                            WhatsApp
                        </button>
                    </div>
                    <button onclick="copyLink()"
                            class="w-full mt-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                            📋 Copier le lien
                    </button>
                </div>

                {{-- Info Card --}}
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold mb-3">ℹ️ À propos</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Format</span>
                            <span class="font-medium">{{ $proposal->format }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Thème</span>
                            <span class="font-medium">{{ $proposal->theme }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut</span>
                            <span class="font-medium">{{ $proposal->status_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Proposé le</span>
                            <span class="font-medium">{{ $proposal->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Breaking News --}}
                @if($breakingNews->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="text-red-600">🔴</span>
                        À la une
                    </h3>
                    <div class="space-y-4">
                        @foreach($breakingNews as $news)
                        <a href="{{ route('publication.show', $news) }}"
                           class="block group">
                            <h4 class="font-semibold text-sm group-hover:text-red-600 transition line-clamp-2">
                                {{ $news->title }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $news->published_at->diffForHumans() }}
                            </p>
                        </a>
                        @if(!$loop->last)
                        <hr>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Share Functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $proposal->title }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $proposal->title }}');
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Lien copié dans le presse-papier !');
    });
}
</script>
@endpush
@endsection
