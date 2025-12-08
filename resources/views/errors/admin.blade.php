@php
    // Récupère le code d'erreur
    $errorCode = $exception->getStatusCode() ?? 500;

    // Configuration des messages selon le code d'erreur
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

    // Récupère les infos de l'erreur
    $errorInfo = $errors[$errorCode] ?? [
        'title' => 'Erreur',
        'message' => 'Une erreur inattendue s\'est produite.',
        'icon' => 'fas fa-exclamation-circle',
        'color' => 'secondary'
    ];
@endphp

@extends('layouts.admin')

@section('page-title', $errorInfo['title'])

@section('content')
<div class="container py-5">
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

                @if(config('app.debug') && isset($exception))
                    <div class="alert alert-warning text-start mb-4">
                        <!--strong>Message technique :</strong-->
                        <br>
                        {{ $exception->getMessage() }}
                    </div>
                @endif

                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-{{ $errorInfo['color'] }} btn-lg">
                        <i class="fas fa-home me-2"></i>Retour au tableau de bord
                    </a>

                    @if($errorCode === 404)
                        <button onclick="window.history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </button>
                    @endif

                    @if(in_array($errorCode, [419, 500, 503]))
                        <button onclick="window.location.reload()" class="btn btn-outline-{{ $errorInfo['color'] }} btn-lg">
                            <i class="fas fa-sync-alt me-2"></i>Rafraîchir
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
