@extends('layouts.frontend')

@section('title', 'Acheter un numéro du Ligne claire News')
@section('meta_description', 'Achetez les numéros du Ligne claire News en version papier ou numérique. 2 ans d\'archives disponibles.')

@section('content')

<div class="bg-gray-100 min-h-screen">
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4">
        <nav class="text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Accueil
                </a></li>
                <li>/</li>
                <li class="text-gray-900 font-semibold">Achat au numéro du journal</li>
            </ol>
        </nav>
    </div>

    <!-- Hero Section - Journal Actuel -->
    <section class="py-12 bg-gradient-to-b from-gray-200 to-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-black text-center mb-6 uppercase tracking-tight">
                Acheter un numéro du Ligne claire News
            </h1>

            <p class="text-center text-gray-700 max-w-3xl mx-auto mb-8">
                Vous n'avez pas pu vous procurer un numéro récent du « Canard » ou vous souhaitez acheter un numéro ancien pour vous ou pour l'offrir ?<br>
                Le Ligne claire News vous propose <strong>2 ans d'archives du journal</strong>, en achat à l'unité, sur support papier et en version numérique.
            </p>

            <div class="border-t-4 border-red-600 w-32 mx-auto mb-12"></div>

            <!-- Journal Actuel Card -->
            @if(isset($currentIssue))
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <!-- Image du journal -->
                        <div class="p-8 md:p-12">
                            <div class="bg-white shadow-xl transform hover:scale-105 transition duration-300">
                                @if($currentIssue->cover_image)
                                    <img src="{{ asset('storage/' . $currentIssue->cover_image) }}"
                                         alt="Couverture {{ $currentIssue->title }}"
                                         class="w-full h-auto">
                                @else
                                    <div class="aspect-[3/4] bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                                        <span class="text-white text-6xl">📰</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Détails et boutons d'achat -->
                        <div class="p-8 md:pr-12">
                            <div class="mb-6">
                                <span class="inline-block bg-red-600 text-white px-4 py-2 rounded-full text-xs font-bold uppercase mb-4">
                                    Cette semaine
                                </span>
                                <h2 class="text-3xl font-black mb-2 uppercase">
                                    {{ $currentIssue->formatted_date }}
                                </h2>
                                <p class="text-xl text-gray-600 font-semibold">
                                    Numéro {{ $currentIssue->issue_number }}
                                </p>
                            </div>

                            <div class="mb-8">
                                <div class="bg-red-600 text-white inline-block px-6 py-3 rounded-lg">
                                    <span class="text-3xl font-black">{{ number_format($currentIssue->price, 2) }} FCFA</span>
                                </div>
                            </div>

                            <!-- Boutons d'achat -->
                            <div class="space-y-4">
                                <a href="{{ route('shop.purchase', ['id' => $currentIssue->id, 'format' => 'digital']) }}"
                                   class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    📱 Acheter en version numérique
                                </a>

                                <a href="{{ route('shop.purchase', ['id' => $currentIssue->id, 'format' => 'paper']) }}"
                                   class="block w-full bg-white hover:bg-gray-50 text-gray-800 text-center px-8 py-4 rounded-xl font-bold text-lg border-3 border-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    📄 Acheter en version papier
                                </a>
                            </div>

                            <p class="text-sm text-gray-500 mt-4 text-center">
                                ✓ Paiement sécurisé • ✓ Livraison rapide
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Tous les numéros disponibles -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-black text-center mb-12 uppercase">
                Tous les numéros du Ligne claire News
            </h2>

            <!-- Formulaire de recherche -->
            <div class="max-w-5xl mx-auto mb-12">
                <form action="{{ route('shop.search') }}" method="GET" class="bg-gray-100 p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <!-- Recherche par numéro -->
                        <div>
                            <label for="issue_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rechercher par numéro :
                            </label>
                            <input type="text"
                                   id="issue_number"
                                   name="issue_number"
                                   value="{{ request('issue_number') }}"
                                   placeholder="Ex: {{ now()->format('y') . '0001' }}"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <!-- Recherche par date - Mois -->
                        <div>
                            <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rechercher par date :
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <select name="month"
                                        id="month"
                                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Mois</option>
                                    @foreach(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $index => $month)
                                        <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Année -->
                                <select name="year"
                                        id="year"
                                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Année</option>
                                    @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Bouton de recherche -->
                        <div>
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-bold uppercase transition shadow-lg hover:shadow-xl">
                                Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Grille des numéros -->
            @if(isset($issues) && $issues->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($issues as $issue)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Image de couverture -->
                    <div class="relative group">
                        @if($issue->cover_image)
                            <img src="{{ asset('storage/' . $issue->cover_image) }}"
                                 alt="Numéro {{ $issue->issue_number }}"
                                 class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                                <span class="text-white text-6xl">📰</span>
                            </div>
                        @endif

                        <!-- Overlay au survol -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                                <span class="text-white font-bold text-lg">Voir les détails</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informations -->
                    <div class="p-5">
                        <div class="mb-3">
                            <span class="text-xs font-semibold text-red-600 uppercase">
                                N° {{ $issue->issue_number }}
                            </span>
                            <h3 class="font-bold text-lg text-gray-900 mt-1">
                                {{ $issue->formatted_date }}
                            </h3>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-black text-red-600">
                                {{ number_format($issue->price, 2) }} FCFA
                            </span>
                        </div>

                        <!-- Boutons d'achat -->
                        <div class="space-y-2">
                            <a href="{{ route('shop.purchase', ['id' => $issue->id, 'format' => 'paper']) }}"
                               class="block text-center bg-white hover:bg-gray-50 text-gray-900 px-4 py-2 rounded-lg font-semibold border-2 border-gray-900 transition text-sm">
                                Version papier
                            </a>
                            <a href="{{ route('shop.purchase', ['id' => $issue->id, 'format' => 'digital']) }}"
                               class="block text-center bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                Version numérique
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $issues->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-600">Aucun numéro trouvé pour votre recherche.</p>
            </div>
            @endif
        </div>
    </section>
</div>

@endsection
