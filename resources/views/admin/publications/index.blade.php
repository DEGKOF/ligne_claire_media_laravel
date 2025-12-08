@extends('layouts.admin')

@section('page-title', 'Publications')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-black">
            @if (in_array(auth()->user()->role, ['admin', 'master_admin']))
                Toutes les publications
            @else
                Mes publications
            @endif
        </h1>
        <a href="{{ route('admin.publications.create') }}"
            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition flex items-center gap-2">
            <span class="text-xl">+</span> Nouvelle publication
        </a>
    </div>

    <!-- Stats personnelles (pour les non-admins) -->
    @if (!in_array(auth()->user()->role, ['admin', 'master_admin']))
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total publications</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $publications->total() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <span class="text-3xl">📰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Vues totales</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ number_format($publications->sum('views_count')) }}
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <span class="text-3xl">👁️</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Publiées</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $publications->where('status', 'published')->count() }}
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <span class="text-3xl">✅</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.publications.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Rechercher..."
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">

            <!-- Rubrique -->
            <select name="rubrique_id"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Toutes les rubriques</option>
                @foreach ($rubriques as $rubrique)
                    <option value="{{ $rubrique->id }}" {{ request('rubrique_id') == $rubrique->id ? 'selected' : '' }}>
                        {{ $rubrique->icon }} {{ $rubrique->name }}
                    </option>
                @endforeach
            </select>

            <!-- Status -->
            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Tous les statuts</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publié</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                {{-- <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Masqué</option> --}}
                {{-- <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option> --}}
            </select>

            <!-- Type -->
            <select name="type"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Tous les types</option>
                <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>Article</option>
                {{-- <option value="direct" {{ request('type') == 'direct' ? 'selected' : '' }}>Direct</option>
                <option value="rediffusion" {{ request('type') == 'rediffusion' ? 'selected' : '' }}>Rediffusion</option>
                <option value="video_courte" {{ request('type') == 'video_courte' ? 'selected' : '' }}>Vidéo courte
                </option>
                <option value="lien_externe" {{ request('type') == 'lien_externe' ? 'selected' : '' }}>Lien externe --}}
                </option>
            </select>

            <!-- Submit -->
            <button type="submit"
                class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-900 transition">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Publications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Publication
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rubrique
                        </th>
                        @if (in_array(auth()->user()->role, ['admin', 'master_admin']))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Auteur
                            </th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vues
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($publications as $publication)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 relative">
                                        @if ($publication->featured_image)
                                            @php
                                                $extension = pathinfo($publication->featured_image, PATHINFO_EXTENSION);
                                                $isVideo = in_array(strtolower($extension), [
                                                    'mp4',
                                                    'mov',
                                                    'avi',
                                                    'webm',
                                                ]);

                                                // Préparer les données pour le modal
                                                $mediaData = [
                                                    'title' => $publication->title,
                                                    'mediaUrl' => asset('storage/' . $publication->featured_image),
                                                    'isVideo' => $isVideo,
                                                    'extension' => $extension,
                                                    'rubrique' => $publication->rubrique->name,
                                                    'date' => $publication->published_at?->format('d/m/Y') ?? 'N/A',
                                                    'views' => number_format($publication->views_count),
                                                ];
                                            @endphp

                                            @if ($isVideo)
                                                <!-- Miniature vidéo cliquable -->
                                                <button onclick="openMediaModal({{ json_encode($mediaData) }})"
                                                    class="relative h-12 w-12 rounded overflow-hidden bg-black cursor-pointer hover:ring-2 hover:ring-blue-500 transition group"
                                                    title="Cliquer pour prévisualiser la vidéo">
                                                    <video class="h-full w-full object-cover" muted>
                                                        <source
                                                            src="{{ asset('storage/' . $publication->featured_image) }}"
                                                            type="video/{{ $extension }}">
                                                    </video>
                                                    <!-- Overlay play mini -->
                                                    <div
                                                        class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/50 transition">
                                                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                        </svg>
                                                    </div>
                                                    <!-- Badge VIDEO mini -->
                                                    <span
                                                        class="absolute top-0 right-0 bg-red-600 text-white text-[8px] font-bold px-1 rounded-bl">
                                                        📹
                                                    </span>
                                                </button>
                                            @else
                                                <!-- Image cliquable -->
                                                <button onclick="openMediaModal({{ json_encode($mediaData) }})"
                                                    class="h-12 w-12 rounded overflow-hidden cursor-pointer hover:ring-2 hover:ring-blue-500 transition"
                                                    title="Cliquer pour prévisualiser l'image">
                                                    <img class="h-full w-full object-cover"
                                                        src="{{ asset('storage/' . $publication->featured_image) }}"
                                                        alt="">
                                                </button>
                                            @endif
                                        @else
                                            <!-- Pas de média - non cliquable -->
                                            <div
                                                class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center text-gray-500">
                                                📰
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 max-w-md truncate">
                                            {{ $publication->title }}
                                        </div>
                                        @if ($publication->is_new)
                                            <span class="text-xs font-semibold text-red-600">NEW</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $publication->rubrique->icon }} {{ $publication->rubrique->name }}
                                </span>
                            </td>
                            @if (in_array(auth()->user()->role, ['admin', 'master_admin']))
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $publication->user->public_name }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $publication->user->nom . ' ' . $publication->user->prenom ?? '' }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-semibold">
                                    @switch($publication->type)
                                        @case('article')
                                            Article
                                        @break

                                        @case('direct')
                                            Direct
                                        @break

                                        @case('rediffusion')
                                            Rediffusion
                                        @break

                                        @case('video_courte')
                                            Short
                                        @break

                                        @case('lien_externe')
                                            Externe
                                        @break
                                    @endswitch
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($publication->status)
                                    @case('published')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Publié
                                        </span>
                                    @break

                                    @case('draft')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Brouillon
                                        </span>
                                    @break

                                    {{-- @case('hidden')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Masqué
                                    </span>
                                @break

                                @case('archived')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Archivé
                                    </span>
                                @break --}}
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($publication->views_count) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $publication->published_at?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    @if ($publication->status === 'published')
                                        <a href="{{ route('publication.show', $publication->slug) }}" target="_blank"
                                            style="text-decoration: underline" class="text-gray-600 hover:text-gray-900"
                                            title="Voir">
                                            Voir
                                        </a>
                                    @else
                                        <button
                                            onclick="showPendingModal('{{ addslashes($publication->title) }}', '{{ $publication->status }}')"
                                            style="text-decoration: underline" class="text-gray-600 hover:text-gray-900"
                                            title="Article non publié">
                                            Voir
                                        </button>
                                    @endif

                                    @php
                                        $isAdmin = in_array(auth()->user()->role, ['admin', 'master_admin']);
                                        $isOwner = $publication->user_id === auth()->id();
                                        $isPublished = $publication->status === 'published';

                                        // Admin peut toujours modifier, utilisateur normal seulement si non publié
                                        $canEdit = $isAdmin || ($isOwner && !$isPublished);
                                    @endphp

                                    @if ($canEdit)
                                        <a href="{{ route('admin.publications.edit', $publication) }}"
                                            style="text-decoration: underline" class="text-blue-600 hover:text-blue-900"
                                            title="Modifier">
                                            Modifier
                                        </a>

                                        @if ($isAdmin)
                                            <form action="{{ route('admin.publications.destroy', $publication) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="text-decoration: underline"
                                                    class="text-red-600 hover:text-red-900" title="Supprimer">
                                                    Supp
                                                </button>
                                            </form>
                                        @elseif($isOwner && !$isPublished)
                                            <button style="text-decoration: underline"
                                                class="text-red-600 hover:text-red-900" title="Supprimer">
                                                Supp (🔒)
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-4xl mb-4">📭</div>
                                    <p class="text-lg">Aucune publication trouvée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $publications->withQueryString()->links() }}
        </div>

        <!-- Modal Preview Média -->
        <div id="mediaPreviewModal"
            class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="relative max-w-4xl w-full">
                <!-- Bouton fermer -->
                <button onclick="closeMediaModal()"
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-bold">
                    ×
                </button>

                <!-- Conteneur du média -->
                <div id="mediaContainer" class="rounded-lg overflow-hidden">
                    <!-- Le contenu sera injecté ici par JavaScript -->
                </div>
            </div>
        </div>

        <!-- Modal Article en attente -->
        <div id="pendingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="text-6xl mb-4">⏳</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2" id="pendingTitle">Article non publié</h3>
                    <p class="text-gray-600 mb-4" id="pendingMessage">
                        Cet article est en attente de validation et n'est pas encore accessible au public.
                    </p>
                    <div class="bg-gray-100 rounded-lg p-3 mb-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Statut:</span> <span id="pendingStatus" class="font-medium"></span>
                        </p>
                    </div>
                    <button onclick="closePendingModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Fermer
                    </button>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function openMediaModal(publication) {
                    const modal = document.getElementById('mediaPreviewModal');
                    const container = document.getElementById('mediaContainer');

                    // Créer le contenu du média
                    if (publication.isVideo) {
                        container.innerHTML = `
                        <video controls autoplay class="w-full h-auto max-h-[70vh]" preload="metadata">
                            <source src="${publication.mediaUrl}" type="video/${publication.extension}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    `;
                    } else {
                        container.innerHTML = `
                        <img src="${publication.mediaUrl}" alt="${publication.title}" class="w-full h-auto max-h-[70vh] object-contain">
                    `;
                    }

                    // Afficher le modal
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeMediaModal() {
                    const modal = document.getElementById('mediaPreviewModal');
                    const container = document.getElementById('mediaContainer');

                    // Arrêter la vidéo si elle joue
                    const video = container.querySelector('video');
                    if (video) {
                        video.pause();
                        video.currentTime = 0;
                    }

                    // Vider le conteneur
                    container.innerHTML = '';

                    // Masquer le modal
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                function showPendingModal(title, status) {
                    const modal = document.getElementById('pendingModal');
                    const statusElement = document.getElementById('pendingStatus');
                    const messageElement = document.getElementById('pendingMessage');

                    // Définir le message en fonction du statut
                    let message = '';
                    let statusText = '';

                    switch (status) {
                        case 'draft':
                            statusText = 'Brouillon';
                            message = 'Cet article est encore en brouillon et n\'est pas accessible au public.';
                            break;
                        case 'hidden':
                            statusText = 'Masqué';
                            message = 'Cet article a été masqué et n\'est pas visible sur le site.';
                            break;
                        case 'archived':
                            statusText = 'Archivé';
                            message = 'Cet article a été archivé et n\'est plus accessible au public.';
                            break;
                        default:
                            statusText = 'En attente';
                            message = 'Cet article est en attente de validation et n\'est pas encore accessible au public.';
                    }

                    statusElement.textContent = statusText;
                    messageElement.textContent = message;

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closePendingModal() {
                    const modal = document.getElementById('pendingModal');
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                // Fermer avec la touche Échap
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeMediaModal();
                        closePendingModal();
                    }
                });

                // Fermer en cliquant en dehors
                document.getElementById('mediaPreviewModal')?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeMediaModal();
                    }
                });

                document.getElementById('pendingModal')?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePendingModal();
                    }
                });
            </script>
        @endpush
    @endsection
