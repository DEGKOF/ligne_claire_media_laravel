<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - LIGNE CLAIRE MÉDIA+</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-field {
            border: none;
            border-bottom: 2px solid #e5e7eb;
            background: transparent;
            transition: all 0.3s ease;
            padding: 0.75rem 0;
            width: 100%;
            font-size: 1rem;
            outline: none;
        }

        .input-field:focus {
            border-bottom-color: #667eea;
        }

        .input-field::placeholder {
            color: #9ca3af;
        }

        .input-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.5rem;
            display: block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .checkbox-custom {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 2px solid #d1d5db;
            cursor: pointer;
        }

        .checkbox-custom:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .link-hover {
            transition: color 0.3s ease;
        }

        .link-hover:hover {
            color: #667eea;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <div class="login-container w-full max-w-md rounded-2xl shadow-2xl p-8 md:p-10">

        <!-- Logo -->
        <div class="logo-circle">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </div>

        <!-- Titre -->
        <h1 class="text-3xl font-black text-center text-gray-800 mb-2">
            Bon retour !
        </h1>
        <p class="text-center text-gray-600 mb-8">
            Connectez-vous à votre compte LCM+
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="input-label">
                    Adresse email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input-field"
                    placeholder="exemple@email.com"
                    required
                    autofocus
                    autocomplete="username"
                />
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="mb-6">
                <label for="password" class="input-label">
                    Mot de passe
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                />
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center cursor-pointer">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="checkbox-custom"
                    />
                    <span class="ml-2 text-sm text-gray-600">
                        Se souvenir de moi
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-600 link-hover font-medium">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <!-- Bouton de connexion -->
            <button type="submit" class="btn-primary">
                Se connecter
            </button>

            <!-- Lien d'inscription -->
            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-600 mt-6">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}"
                       class="font-semibold text-gray-800 link-hover">
                        Créer un compte
                    </a>
                </p>
            @endif

            <!-- Retour à l'accueil -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center text-sm text-gray-600 link-hover font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        </form>

    </div>

</body>
</html>
