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
            <!-- Grille des membres -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($members as $member)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group">
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
                                <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                    {{ $member->bio }}
                                </p>
                            @endif

                            <!-- Contact -->
                            <div class="space-y-2">
                                @if($member->email)
                                    <a href="mailto:{{ $member->email }}"
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600 transition">
                                        <i class="fas fa-envelope text-blue-500"></i>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </a>
                                @endif

                                @if($member->telephone)
                                    <a href="tel:{{ $member->telephone }}"
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600 transition">
                                        <i class="fas fa-phone text-blue-500"></i>
                                        <span>{{ $member->telephone }}</span>
                                    </a>
                                @endif
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
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
