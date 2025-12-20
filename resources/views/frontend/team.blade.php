@extends('layouts.frontend')

@section('title', 'Notre équipe - Ligne Claire Média+')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Notre Équipe
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Découvrez les passionnés qui font vivre Ligne Claire Média+ au quotidien.
                Une équipe dédiée à vous informer avec rigueur et professionnalisme.
            </p>
        </div>

        @if($members->isEmpty())
            <!-- Message si aucun membre -->
            <div class="text-center py-16">
                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500">Aucun membre de l'équipe pour le moment.</p>
            </div>
        @else
            @php
                $memberCount = count($members);

                if ($memberCount <= 3) {
                    $gridClasses = 'grid-cols-1 md:grid-cols-' . $memberCount . ' max-w-6xl mx-auto';
                } elseif ($memberCount == 4) {
                    $gridClasses = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4';
                } else {
                    $gridClasses = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4';
                }
            @endphp

            <!-- Grille des membres -->
            <div class="grid gap-8 {{ $gridClasses }}">
                @foreach($members as $member)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group cursor-pointer"
                        onclick="openMemberModal({{ $member->id }})">
                        <!-- Photo -->
                        <div class="relative h-64 bg-gradient-to-br from-blue-500 to-blue-700 overflow-hidden">
                            @if($member->photo)
                                <img src="{{ $member->photo_url }}"
                                    alt="{{ $member->full_name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <!-- Avatar par défaut avec initiales -->
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-white text-6xl font-bold">
                                        {{ strtoupper(substr($member->prenom, 0, 1) . substr($member->nom, 0, 1)) }}
                                    </div>
                                </div>
                            @endif

                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Badge "Voir plus" -->
                            <div class="absolute bottom-4 right-4 bg-white text-blue-600 px-4 py-2 rounded-full text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg">
                                <i class="fas fa-eye mr-1"></i> Voir plus
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-6">
                            <!-- Nom et poste -->
                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                {{ $member->full_name }}
                            </h3>
                            <p class="text-blue-600 font-medium mb-4">
                                {{ $member->poste }}
                            </p>

                            <!-- Bio -->
                            @if($member->bio)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                    {{ $member->bio }}
                                </p>
                            @endif

                            <!-- Contact -->
                            <div class="space-y-2">
                                @if($member->email)
                                    <a href="mailto:{{ $member->email }}"
                                        onclick="event.stopPropagation()"
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600 transition">
                                        <i class="fas fa-envelope text-blue-500"></i>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </a>
                                @endif

                                @if($member->telephone)
                                    <a href="tel:{{ $member->telephone }}"
                                        onclick="event.stopPropagation()"
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600 transition">
                                        <i class="fas fa-phone text-blue-500"></i>
                                        <span>{{ $member->telephone }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour chaque membre -->
                    <div id="memberModal{{ $member->id }}"
                        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4"
                        onclick="closeMemberModal({{ $member->id }})">
                        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl"
                            onclick="event.stopPropagation()">
                            <!-- Header du modal -->
                            <div class="relative">
                                @if($member->photo)
                                    <div class="h-64 md:h-80 bg-gradient-to-br from-blue-500 to-blue-700 overflow-hidden">
                                        <img src="{{ $member->photo_url }}"
                                            alt="{{ $member->full_name }}"
                                            class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    </div>
                                @else
                                    <div class="h-64 md:h-80 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                        <div class="text-white text-8xl font-bold">
                                            {{ strtoupper(substr($member->prenom, 0, 1) . substr($member->nom, 0, 1)) }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Bouton fermer -->
                                <button onclick="closeMemberModal({{ $member->id }})"
                                        class="absolute top-4 right-4 bg-white text-gray-700 rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition shadow-lg">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <!-- Contenu du modal -->
                            <div class="p-8">
                                <!-- Nom et poste -->
                                <div class="mb-6">
                                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                                        {{ $member->full_name }}
                                    </h2>
                                    <p class="text-xl text-blue-600 font-semibold">
                                        {{ $member->poste }}
                                    </p>
                                </div>

                                <!-- Biographie complète -->
                                @if($member->bio)
                                    <div class="mb-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                            <i class="fas fa-user-circle text-blue-600"></i>
                                            Biographie
                                        </h3>
                                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-justify">
                                            {{ $member->bio }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Informations de contact -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <i class="fas fa-address-card text-blue-600"></i>
                                        Contact
                                    </h3>
                                    <div class="space-y-3">
                                        @if($member->email)
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                                <i class="fas fa-envelope text-blue-600 text-xl"></i>
                                                <div>
                                                    <p class="text-xs text-gray-500 uppercase">Email</p>
                                                    <a href="mailto:{{ $member->email }}"
                                                    class="text-gray-900 hover:text-blue-600 transition font-medium">
                                                        {{ $member->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if($member->telephone)
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                                <i class="fas fa-phone text-blue-600 text-xl"></i>
                                                <div>
                                                    <p class="text-xs text-gray-500 uppercase">Téléphone</p>
                                                    <a href="tel:{{ $member->telephone }}"
                                                    class="text-gray-900 hover:text-blue-600 transition font-medium">
                                                        {{ $member->telephone }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-3 pt-4 border-t">
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}"
                                        class="flex-1 min-w-[200px] bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                                            <i class="fas fa-envelope mr-2"></i>
                                            Envoyer un email
                                        </a>
                                    @endif

                                    @if($member->telephone)
                                        <a href="tel:{{ $member->telephone }}"
                                        class="flex-1 min-w-[200px] bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition text-center">
                                            <i class="fas fa-phone mr-2"></i>
                                            Appeler
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Rejoignez Notre Équipe</h2>
            <p class="text-lg text-blue-100 mb-6 max-w-2xl mx-auto">
                Vous êtes passionné par le journalisme et souhaitez faire partie de l'aventure Ligne Claire Média+ ?
                Envoyez-nous votre candidature !
            </p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center gap-2 bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-blue-50 transition shadow-lg">
                <i class="fas fa-paper-plane"></i>
                Nous contacter
            </a>
        </div>
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    function openMemberModal(memberId) {
        const modal = document.getElementById('memberModal' + memberId);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeMemberModal(memberId) {
        const modal = document.getElementById('memberModal' + memberId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Fermer le modal avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="memberModal"]');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = 'auto';
        }
    });
</script>
@endsection
