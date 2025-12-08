@php
    // Même configuration que admin.blade.php
    $errorCode = $exception->getStatusCode() ?? 500;

    $errors = [
        400 => [
            'title' => 'Requête invalide',
            'message' => 'La requête envoyée est incorrecte ou mal formée.',
            'icon' => 'fas fa-exclamation-triangle',
            'color' => 'warning'
        ],
        401 => [
            'title' => 'Non autorisé',
            'message' => 'Vous devez être authentifié pour accéder à cette ressource.',
            'icon' => 'fas fa-lock',
            'color' => 'danger'
        ],
        403 => [
            'title' => 'Accès refusé',
            'message' => 'Vous n\'avez pas l\'autorisation d\'accéder à cette ressource.',
            'icon' => 'fas fa-ban',
            'color' => 'danger'
        ],
        404 => [
            'title' => 'Page non trouvée',
            'message' => 'Désolé, la page que vous recherchez n\'existe pas ou a été déplacée.',
            'icon' => 'fas fa-search',
            'color' => 'primary'
        ],
        419 => [
            'title' => 'Session expirée',
            'message' => 'Votre session a expiré. Veuillez rafraîchir la page et réessayer.',
            'icon' => 'fas fa-clock',
            'color' => 'warning'
        ],
        429 => [
            'title' => 'Trop de requêtes',
            'message' => 'Vous avez effectué trop de requêtes. Veuillez patienter quelques instants.',
            'icon' => 'fas fa-hourglass-half',
            'color' => 'warning'
        ],
        500 => [
            'title' => 'Erreur serveur',
            'message' => 'Une erreur interne s\'est produite. Nos équipes ont été notifiées.',
            'icon' => 'fas fa-server',
            'color' => 'danger'
        ],
        503 => [
            'title' => 'Service temporairement indisponible',
            'message' => 'Le site est en maintenance. Nous serons de retour très bientôt.',
            'icon' => 'fas fa-tools',
            'color' => 'info'
        ],
    ];

    $errorInfo = $errors[$errorCode] ?? [
        'title' => 'Erreur',
        'message' => 'Une erreur inattenue s\'est produite.',
        'icon' => 'fas fa-exclamation-circle',
        'color' => 'secondary'
    ];
@endphp

@extends('layouts.frontend')

@section('title', $errorInfo['title'] . ' - LIGNE CLAIRE MÉDIA+')

@section('content')
<div class="section py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="error-content text-center">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-{{ $errorInfo['color'] }}" style="font-size: 8rem;">
                        {{ $errorCode }}
                    </h1>
                </div>

                <div class="error-icon mb-3">
                    <i class="{{ $errorInfo['icon'] }} fa-3x text-{{ $errorInfo['color'] }}"></i>
                </div>

                <h2 class="mb-3">{{ $errorInfo['title'] }}</h2>

                <p class="text-muted mb-4 lead">
                    {{ $errorInfo['message'] }}
                </p>

                {{-- @if(config('app.debug') && isset($exception))
                    <div class="alert alert-warning text-start mb-4">
                        <strong>Message technique :</strong><br>
                        {{ $exception->getMessage() }}
                    </div>
                @endif --}}
                    <br><br><br>
<div class="d-flex gap-4 justify-content-center flex-wrap">
    <a href="{{ route('home') }}" class="btn btn-{{ $errorInfo['color'] }} btn-lg">
        <svg class="me-2" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Retour à l'accueil
    </a>

    @if($errorCode === 404)
        <button onclick="window.history.back()" class="btn btn-outline-secondary btn-lg">
            <svg class="me-2" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </button>
    @endif

    @if(in_array($errorCode, [419, 500, 503]))
        <button onclick="window.location.reload()" class="btn btn-outline-{{ $errorInfo['color'] }} btn-lg">
            <svg class="me-2" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Rafraîchir
        </button>
    @endif
</div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-content {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-code h1 {
        line-height: 1;
    }

    @media (max-width: 768px) {
        .error-code h1 {
            font-size: 5rem !important;
        }
    }
</style>
@endsection
