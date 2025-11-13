@extends('layouts.frontend')

@section('title', 'Acheter un numéro du Ligne claire News')
@section('meta_description', 'Achetez les numéros du Ligne claire News en version numérique. 2 ans d\'archives disponibles.')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


@section('content')

<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4">
        <nav class="text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600 flex items-center gap-1">
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
    <section class="py-12 ">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-black text-center mb-6 uppercase tracking-tight">
                Acheter un numéro du Ligne claire News
            </h1>

            <p class="text-center text-gray-700 max-w-3xl mx-auto mb-8">
               <strong>Zéro papier. Peu de bruit. Juste l’essentiel. <br>
                 Sans impression, sans gaspillage, et connecté à son public partout, tout le temps.
                </strong>
{{-- <br><br><br> --}}


                {{-- Ligne Claire Média+ est un média 100 % numérique qui réinvente la manière de s’informer au Bénin et en Afrique francophone.
Nous croyons qu’un média moderne doit être libre, interactif et durable — sans impression, sans gaspillage, et connecté à son public partout, tout le temps. --}}
<br>
{{-- <br><br> --}}
                Vous n'avez pas pu vous procurer un numéro récent du « Ligne claire News » ou vous souhaitez acheter un numéro ancien pour vous ou pour l'offrir ?<br>
                Le Ligne claire News vous propose <strong>2 ans d'archives du journal</strong>, en achat à l'unité, en version numérique.
            </p>

            <div class="border-t-4 border-blue-600 w-32 mx-auto mb-12"></div>

            <!-- Journal Actuel Card - Style Image 2 -->
            @if(isset($currentIssue))
            <div class="max-w-6xl mx-auto">
                <div class="relative">
                    <!-- Bandeau jaune gauche -->
                    {{-- <div class="absolute left-0 top-1/4 w-64 h-32 bg-blue-400 -ml-20 transform -rotate-3 z-0 hidden lg:block"></div>

                    <!-- Bandeau jaune droit -->
                    <div class="absolute right-0 bottom-1/4 w-64 h-32 bg-blue-400 -mr-20 transform rotate-3 z-0 hidden lg:block"></div> --}}

                    <!-- Contenu principal -->
                    <div class="relative z-10 bg-white rounded-lg shadow-2xl p-8 lg:p-12">
                        <div class="grid lg:grid-cols-2 gap-8 items-center">
                            <!-- Image du journal -->
                            <div class="flex justify-center">
                                <div class="bg-white shadow-2xl transform hover:scale-105 transition duration-300 max-w-md">
                                    @if($currentIssue->cover_image)
                                        <img src="{{ asset('storage/' . $currentIssue->cover_image) }}"
                                             alt="Couverture {{ $currentIssue->title }}"
                                             class="w-full h-auto">
                                    @else
                                        <div class="aspect-[3/4] bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                            <span class="text-white text-6xl">📰</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Détails et bouton d'achat -->
                            <div class="text-center lg:text-left">
                                <span class="inline-block bg-blue-600 text-white px-6 py-2 text-sm font-bold uppercase mb-6">
                                    Cette semaine
                                </span>

                                <h2 class="text-4xl lg:text-5xl font-black mb-2 uppercase leading-tight">
                                    {{ $currentIssue->formatted_date }}
                                </h2>

                                <p class="text-xl text-gray-600 font-semibold mb-8">
                                    Numéro {{ $currentIssue->issue_number }}
                                </p>

                                <div class="mb-8">
                                    <div class="inline-block bg-blue-600 text-white px-8 py-3 rounded text-xl font-black">
                                        {{ number_format($currentIssue->digital_price, 2) }} FCFA
                                    </div>
                                </div>

                                <!-- Bouton d'achat version numérique uniquement -->
                                <a href="{{ route('shop.purchase', ['id' => $currentIssue->id, 'format' => 'digital']) }}"
                                   class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-12 py-5 rounded-xl font-bold text-lg uppercase transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                    Acheter en version numérique
                                </a>

                                <p class="text-sm text-gray-500 mt-6">
                                    ✓ Paiement sécurisé • ✓ Accès immédiat
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Tous les numéros disponibles -->
    <section class="py-16">
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
                                   placeholder="Ex: 5475"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Recherche par date -->
                        <div>
                            <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rechercher par date :
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <select name="month"
                                        id="month"
                                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Mois</option>
                                    @foreach(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $index => $month)
                                        <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="year"
                                        id="year"
                                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                                    class="w-full bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-lg font-bold uppercase transition shadow-lg hover:shadow-xl">
                                Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Grille des numéros - Style Image 1 avec hover -->
            @if(isset($issues) && $issues->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($issues as $issue)
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <!-- Image de couverture -->
                    <div class="relative overflow-hidden">
                        @if($issue->cover_image)
                            <img src="{{ asset('storage/' . $issue->cover_image) }}"
                                 alt="Numéro {{ $issue->issue_number }}"
                                 class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-[500px] bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center transition-transform duration-500 group-hover:scale-105">
                                <span class="text-white text-6xl">📰</span>
                            </div>
                        @endif

                        <!-- Overlay avec détails au hover - Style Image 1 -->
                        <div class="absolute inset-0 bg-white bg-opacity-95 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-center items-center p-6 text-center">
                            <span class="inline-block bg-blue-600 text-white px-4 py-1 text-xs font-bold uppercase mb-4">
                                Cette semaine
                            </span>

                            <h3 class="text-2xl font-black uppercase mb-2">
                                {{ $issue->formatted_date }}
                            </h3>

                            <p class="text-lg font-semibold text-gray-600 mb-6">
                                Numéro {{ $issue->issue_number }}
                            </p>

                            <div class="mb-6">
                                <span class="inline-block bg-blue-600 text-white px-6 py-2 rounded text-xl font-black">
                                    {{ number_format($issue->digital_price, 2) }} FCFA
                                </span>
                            </div>

                            <!-- Bouton version numérique uniquement -->
                            <a href="{{ route('shop.purchase', ['id' => $issue->id, 'format' => 'digital']) }}"
                               class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center px-6 py-4 rounded-xl font-bold uppercase transition shadow-lg transform hover:scale-105">
                                Acheter en version numérique
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
