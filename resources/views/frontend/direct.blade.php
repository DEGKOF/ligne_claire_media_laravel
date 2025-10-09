@extends('layouts.frontend')

@section('title', 'Direct - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Main Video Player -->
    <div class="max-w-6xl mx-auto mb-12">
        <div class="bg-black rounded-xl overflow-hidden shadow-2xl">
            <div class="aspect-video bg-gradient-to-br from-red-900 to-red-600 relative flex items-center justify-center">
                <!-- Placeholder pour le player vidéo -->
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 bg-white/20 border-4 border-white rounded-full flex items-center justify-center text-white text-4xl mb-6 animate-pulse">
                        ▶
                    </div>
                    <h2 class="text-white text-3xl font-bold text-center px-8 mb-4">
                        LIGNE CLAIRE MÉDIA+ EN DIRECT
                    </h2>
                    <div class="flex items-center gap-3 bg-red-600 px-6 py-3 rounded-full animate-pulse">
                        <span class="w-3 h-3 bg-white rounded-full animate-ping"></span>
                        <span class="text-white font-bold uppercase text-sm">En Direct</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 text-white p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold">Journal de {{ now()->format('H') }}h</h3>
                    <div class="flex items-center gap-2 bg-red-600 px-4 py-2 rounded-full">
                        <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                        <span class="font-bold text-sm">{{ number_format(rand(1200, 8500)) }} spectateurs</span>
                    </div>
                </div>
                <p class="text-gray-300">
                    Suivez l'actualité en temps réel avec LIGNE CLAIRE MÉDIA+.
                    Retrouvez nos journalistes pour un point complet sur l'actualité nationale et internationale.
                </p>
            </div>
        </div>
    </div>

    <!-- Programme du jour -->
    <div class="max-w-4xl mx-auto mb-12">
        <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-red-600">Programme du jour</h2>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="space-y-4">
                @php
                    $programmes = [
                        ['time' => '06:00', 'title' => 'Le 6h Info', 'desc' => 'L\'essentiel de l\'actualité dès le réveil'],
                        ['time' => '08:30', 'title' => 'Le Grand Matin', 'desc' => 'Débats et analyses avec nos invités'],
                        ['time' => '12:00', 'title' => 'Journal de Midi', 'desc' => 'Le point sur l\'actualité à la mi-journée'],
                        ['time' => '13:30', 'title' => 'L\'Heure des Pros', 'desc' => 'Le talk-show politique et économique'],
                        ['time' => '18:00', 'title' => 'Le 18h', 'desc' => 'Toute l\'actualité de la journée'],
                        ['time' => '20:00', 'title' => 'Journal de 20h', 'desc' => 'Le rendez-vous incontournable'],
                        ['time' => '21:00', 'title' => 'Face à l\'Info', 'desc' => 'Débat et décryptage de l\'actualité'],
                    ];
                    $currentHour = (int) now()->format('H');
                @endphp

                @foreach($programmes as $prog)
                    @php
                        $progHour = (int) substr($prog['time'], 0, 2);
                        $isLive = $progHour == $currentHour;
                        $isPassed = $progHour < $currentHour;
                    @endphp
                    <div class="flex items-center gap-4 p-4 rounded-lg {{ $isLive ? 'bg-red-50 border-2 border-red-600' : ($isPassed ? 'bg-gray-50' : 'bg-white border border-gray-200') }}">
                        <div class="text-center min-w-[80px]">
                            <div class="text-2xl font-bold {{ $isLive ? 'text-red-600' : ($isPassed ? 'text-gray-400' : 'text-gray-900') }}">
                                {{ $prog['time'] }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg {{ $isLive ? 'text-red-600' : ($isPassed ? 'text-gray-400' : 'text-gray-900') }}">
                                {{ $prog['title'] }}
                                @if($isLive)
                                    <span class="ml-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs animate-pulse">● EN DIRECT</span>
                                @endif
                            </h4>
                            <p class="text-sm {{ $isPassed ? 'text-gray-400' : 'text-gray-600' }}">
                                {{ $prog['desc'] }}
                            </p>
                        </div>
                        @if($isPassed)
                            <a href="{{ route('replay') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                                Revoir
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Directs récents/à venir -->
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 pl-6 border-l-4 border-red-600">Directs à venir</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i = 1; $i <= 3; $i++)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="h-40 bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                    <span class="text-white text-5xl">🎙️</span>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                            Demain • {{ sprintf('%02d', rand(10, 20)) }}h{{ sprintf('%02d', [0, 15, 30, 45][rand(0, 3)]) }}
                        </span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Événement spécial #{{ $i }}</h3>
                    <p class="text-gray-600 text-sm">
                        Ne manquez pas notre couverture en direct de cet événement exceptionnel.
                    </p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
