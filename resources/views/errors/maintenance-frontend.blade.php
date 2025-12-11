<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance en cours - LIGNE CLAIRE MÉDIA+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }
        .background-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite;
        }
        .circle:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-duration: 15s;
        }
        .circle:nth-child(2) {
            width: 120px;
            height: 120px;
            right: 15%;
            animation-duration: 18s;
            animation-delay: 2s;
        }
        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 50%;
            animation-duration: 12s;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.6;
            }
        }
        .maintenance-container {
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
            padding: 4rem 3rem;
            max-width: 650px;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 10;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .logo {
            width: 150px;
            margin-bottom: 2rem;
        }
        .maintenance-icon {
            font-size: 6rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .countdown {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        .countdown-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            min-width: 80px;
        }
        .countdown-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        .countdown-label {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        .social-links {
            margin-top: 2rem;
        }
        .social-links a {
            display: inline-block;
            width: 45px;
            height: 45px;
            line-height: 45px;
            background: #f8f9fa;
            border-radius: 50%;
            margin: 0 0.5rem;
            color: #667eea;
            transition: all 0.3s;
        }
        .social-links a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="background-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="maintenance-container">
        <!-- Logo (si vous en avez un) -->
        {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo"> --}}

        <div class="maintenance-icon">
            <i class="fas fa-rocket"></i>
        </div>

        <h1 class="mb-3" style="color: #2a5298;">Nous revenons bientôt !</h1>

        <p class="lead text-muted mb-4">
            {{-- {{ $exception->getMessage() ?: 'Notre site est actuellement en maintenance pour vous offrir une meilleure expérience.' }} --}}
            {{ isset($exception) ? $exception->getMessage() : 'Notre site est actuellement en maintenance pour vous offrir une meilleure expérience.' }}
        </p>

        <div class="countdown" id="countdown">
            <div class="countdown-item">
                <span class="countdown-number" id="hours">00</span>
                <span class="countdown-label">Heures</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="minutes">00</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="seconds">00</span>
                <span class="countdown-label">Secondes</span>
            </div>
        </div>

        <p class="text-muted mt-4">
            <i class="fas fa-info-circle me-2"></i>
            En attendant, suivez-nous sur nos réseaux sociaux !
        </p>

        <div class="social-links">
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>

        <div class="mt-4">
            <button onclick="location.reload()" class="btn btn-primary btn-lg">
                <i class="fas fa-sync-alt me-2"></i>Rafraîchir
            </button>
        </div>

        <p class="text-muted small mt-4 mb-0">
            <i class="fas fa-envelope me-2"></i>contact@ligneclaire-media.com
        </p>
    </div>

    {{-- <script>
        // Countdown timer
        @if(isset($exception) && method_exists($exception, 'retryAfter'))
            let retryAfter = {{ $exception->retryAfter() }};
        @else
            let retryAfter = 3600; // 1 heure par défaut
        @endif

        function updateCountdown() {
            const hours = Math.floor(retryAfter / 3600);
            const minutes = Math.floor((retryAfter % 3600) / 60);
            const seconds = retryAfter % 60;

            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            if (retryAfter > 0) {
                retryAfter--;
                setTimeout(updateCountdown, 1000);
            } else {
                location.reload();
            }
        }

        updateCountdown();
    </script> --}}
    <script>
    // Countdown timer
    let retryAfter = 3600; // 1 heure par défaut

    function updateCountdown() {
        const hours = Math.floor(retryAfter / 3600);
        const minutes = Math.floor((retryAfter % 3600) / 60);
        const seconds = retryAfter % 60;

        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

        if (retryAfter > 0) {
            retryAfter--;
            setTimeout(updateCountdown, 1000);
        } else {
            location.reload();
        }
    }

    updateCountdown();
</script>
</body>
</html>
