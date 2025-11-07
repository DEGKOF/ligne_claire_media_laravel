@extends('layouts.frontend')

@section('title', 'Espace Annonceurs — Boostez votre visibilité avec LCM+')

@section('meta_description', 'Découvrez nos solutions publicitaires sur LCM+ : bannières, vidéos, contenus sponsorisés. Touchez des milliers de lecteurs chaque jour.')

@section('content')
    <style>
        :root {
            --primary: #1E56B3;
            --primary-dark: #0B2B5A;
            --primary-light: #E8F1FF;
            --accent: #FFC940;
            --success: #1FA37B;
            --danger: #D94B4B;
            --dark: #0e1116;
            --muted: #5E6B7A;
            --border: #E6EEF8;
            --radius: 16px;
            --shadow: 0 12px 28px rgba(10, 35, 80, .10);
            --shadow-lg: 0 20px 50px rgba(10, 35, 80, .2);
        }

        * {
            box-sizing: border-box;
        }

        /* Hero Section */
        .hero-advertisers {
            background: linear-gradient(135deg, #1E56B3 0%, #0B2B5A 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-advertisers::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-advertisers::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,201,64,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 20px;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 50px;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 900;
            color: var(--accent);
            display: block;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Container */
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Section */
        .section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 36px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .section-subtitle {
            font-size: 18px;
            text-align: center;
            color: var(--muted);
            max-width: 700px;
            margin: 0 auto 60px;
            line-height: 1.6;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Pricing Card */
        .pricing-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .pricing-card:hover::before {
            transform: scaleX(1);
        }

        .pricing-card.featured {
            border-color: var(--primary);
            background: linear-gradient(135deg, #f8fbff 0%, #e8f1ff 100%);
        }

        .pricing-card.featured::before {
            transform: scaleX(1);
        }

        .pricing-badge {
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--accent);
            color: var(--dark);
            padding: 5px 40px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            transform: rotate(45deg);
            box-shadow: 0 4px 12px rgba(255, 201, 64, 0.4);
        }

        .pricing-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }

        .pricing-title {
            font-size: 24px;
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .pricing-description {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 30px;
            min-height: 60px;
        }

        .pricing-price {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 30px;
        }

        .pricing-price strong {
            display: block;
            font-size: 36px;
            font-weight: 900;
            color: var(--primary);
            margin: 10px 0;
        }

        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px;
            text-align: left;
        }

        .pricing-features li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pricing-features li:last-child {
            border-bottom: none;
        }

        .pricing-features li::before {
            content: '✓';
            color: var(--success);
            font-weight: 900;
            font-size: 18px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 86, 179, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 86, 179, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-accent {
            background: var(--accent);
            color: var(--dark);
            box-shadow: 0 4px 12px rgba(255, 201, 64, 0.3);
        }

        .btn-accent:hover {
            background: #e6b633;
            transform: translateY(-2px);
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
        }

        .feature-item {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: var(--radius);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(30, 86, 179, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .feature-title {
            font-size: 20px;
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .feature-description {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1E56B3 0%, #0B2B5A 100%);
            color: white;
            padding: 80px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,201,64,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 42px;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .cta-text {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Background colors alternées */
        .bg-alternate-1 {
            background: linear-gradient(135deg, #f8fbff 0%, #e8f1ff 100%);
        }

        .bg-alternate-2 {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
        }

        .bg-alternate-3 {
            background: linear-gradient(135deg, #f0fff4 0%, #e0f7e9 100%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .hero-stats {
                gap: 30px;
            }

            .stat-number {
                font-size: 32px;
            }

            .section-title {
                font-size: 28px;
            }

            .cta-title {
                font-size: 28px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-advertisers">
        <div class="hero-content">
            <h1 class="hero-title">Boostez votre visibilité avec LCM+</h1>
            <p class="hero-subtitle">
                Touchez des milliers de lecteurs engagés chaque jour. Nos solutions publicitaires vous offrent
                une visibilité maximale auprès d'une audience qualifiée et active.
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Visiteurs/mois</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">85%</span>
                    <span class="stat-label">Taux d'engagement</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Visibilité continue</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100+</span>
                    <span class="stat-label">Partenaires actifs</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Offres Publicitaires -->
    <section class="section">
        <div class="container-custom">
            <h2 class="section-title">Nos Solutions Publicitaires</h2>
            <p class="section-subtitle">
                Choisissez la formule qui correspond le mieux à vos objectifs marketing et à votre budget.
            </p>

            <div class="cards-grid">
                <!-- Offre 1: Bannière Standard -->
                <div class="pricing-card">
                    <div class="pricing-icon">📊</div>
                    <h3 class="pricing-title">Bannière Standard</h3>
                    <p class="pricing-description">
                        Idéal pour démarrer. Votre bannière affichée sur l'ensemble du site.
                    </p>
                    <div class="pricing-price">
                        À partir de
                        <strong>25 000 FCFA</strong>
                        /semaine
                    </div>
                    <ul class="pricing-features">
                        <li>Format 728x90 ou 300x250 px</li>
                        <li>Rotation sur toutes les pages</li>
                        <li>Statistiques de performance</li>
                        <li>Support technique inclus</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Commencer</a>
                </div>

                <!-- Offre 2: Pack Premium (Featured) -->
                <div class="pricing-card featured">
                    <div class="pricing-badge">Populaire</div>
                    <div class="pricing-icon">🚀</div>
                    <h3 class="pricing-title">Pack Premium</h3>
                    <p class="pricing-description">
                        Notre offre la plus complète pour une visibilité maximale.
                    </p>
                    <div class="pricing-price">
                        À partir de
                        <strong>75 000 FCFA</strong>
                        /semaine
                    </div>
                    <ul class="pricing-features">
                        <li>Bannière haute visibilité (top page)</li>
                        <li>Popup stratégique (non-intrusif)</li>
                        <li>Story sponsorisée sur réseaux</li>
                        <li>Tableau de bord analytics</li>
                        <li>Support prioritaire 24/7</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary">Choisir Premium</a>
                </div>

                <!-- Offre 3: Contenu Sponsorisé -->
                <div class="pricing-card">
                    <div class="pricing-icon">✍️</div>
                    <h3 class="pricing-title">Contenu Sponsorisé</h3>
                    <p class="pricing-description">
                        Un article dédié à votre marque, rédigé par nos journalistes.
                    </p>
                    <div class="pricing-price">
                        À partir de
                        <strong>150 000 FCFA</strong>
                        /article
                    </div>
                    <ul class="pricing-features">
                        <li>Article de 800-1200 mots</li>
                        <li>Rédaction professionnelle</li>
                        <li>Publication sur site + réseaux</li>
                        <li>SEO optimisé</li>
                        <li>3 révisions incluses</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-secondary">En savoir plus</a>
                </div>

                {{-- <!-- Offre 4: Vidéo Publicitaire -->
                <div class="pricing-card">
                    <div class="pricing-icon">🎥</div>
                    <h3 class="pricing-title">Spot Vidéo</h3>
                    <p class="pricing-description">
                        Votre publicité vidéo diffusée avant nos contenus vidéo.
                    </p>
                    <div class="pricing-price">
                        À partir de
                        <strong>100 000 FCFA</strong>
                        /semaine
                    </div>
                    <ul class="pricing-features">
                        <li>Spot de 15-30 secondes</li>
                        <li>Diffusion sur replays & direct</li>
                        <li>Ciblage par rubrique</li>
                        <li>Rapport détaillé de vues</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Réserver</a>
                </div>

                <!-- Offre 5: Newsletter Sponsorisée -->
                <div class="pricing-card">
                    <div class="pricing-icon">📧</div>
                    <h3 class="pricing-title">Newsletter Sponsorisée</h3>
                    <p class="pricing-description">
                        Atteignez directement notre base d'abonnés engagés.
                    </p>
                    <div class="pricing-price">
                        À partir de
                        <strong>50 000 FCFA</strong>
                        /envoi
                    </div>
                    <ul class="pricing-features">
                        <li>Base de 10 000+ abonnés</li>
                        <li>Bannière dans newsletter</li>
                        <li>Statistiques d'ouverture/clics</li>
                        <li>Segmentation par intérêts</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Commander</a>
                </div>

                <!-- Offre 6: Pack Entreprise -->
                <div class="pricing-card">
                    <div class="pricing-icon">🏢</div>
                    <h3 class="pricing-title">Solution Sur-Mesure</h3>
                    <p class="pricing-description">
                        Une campagne personnalisée adaptée à vos besoins spécifiques.
                    </p>
                    <div class="pricing-price">
                        <strong>Sur devis</strong>
                    </div>
                    <ul class="pricing-features">
                        <li>Campagne multi-canal</li>
                        <li>Contenu exclusif</li>
                        <li>Événement en direct</li>
                        <li>Reporting mensuel</li>
                        <li>Account Manager dédié</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-accent">Nous contacter</a>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Pourquoi LCM+ -->
    <section class="section bg-alternate-1">
        <div class="container-custom">
            <h2 class="section-title">Pourquoi choisir LCM+ ?</h2>
            <p class="section-subtitle">
                Une plateforme média moderne avec une audience engagée et des résultats mesurables.
            </p>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title">Audience Qualifiée</h3>
                    <p class="feature-description">
                        Des lecteurs actifs et intéressés par l'actualité béninoise et régionale.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📈</div>
                    <h3 class="feature-title">ROI Mesurable</h3>
                    <p class="feature-description">
                        Tableau de bord complet avec statistiques en temps réel de vos campagnes.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Diffusion Rapide</h3>
                    <p class="feature-description">
                        Votre publicité en ligne en moins de 24h après validation du contenu.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🤝</div>
                    <h3 class="feature-title">Support Dédié</h3>
                    <p class="feature-description">
                        Une équipe à votre écoute pour optimiser vos campagnes publicitaires.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Paiement Sécurisé</h3>
                    <p class="feature-description">
                        Transactions 100% sécurisées via Mobile Money et cartes bancaires.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📱</div>
                    <h3 class="feature-title">Multi-Plateforme</h3>
                    <p class="feature-description">
                        Visibilité sur web, mobile, newsletter et réseaux sociaux.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Prêt à booster votre visibilité ?</h2>
            <p class="cta-text">
                Rejoignez plus de 100 entreprises qui nous font confiance pour leur communication digitale.
                Connectez-vous dès maintenant pour créer votre première campagne.
            </p>
            <div class="cta-buttons">
                    @auth
                        <a href="{{ route('advertiser.dashboard') }}" target="_blank" class="btn btn-accent">
                            🚀 Accéder à mon espace
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-accent">
                            🚀 Accéder à mon espace
                        </a>
                    @endauth

                <a href="mailto:pub@lcmplus.com" class="btn btn-secondary">
                    📞 Contactez-nous
                </a>
            </div>
        </div>
    </section>

    <script>
        // Animation au scroll pour les cards
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const cardObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, observerOptions);

            // Appliquer l'animation aux pricing cards
            document.querySelectorAll('.pricing-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                cardObserver.observe(card);
            });

            // Appliquer l'animation aux feature items
            document.querySelectorAll('.feature-item').forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                cardObserver.observe(item);
            });
        });

        // Animation des stats au scroll
        const animateStats = () => {
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                const finalValue = stat.textContent.replace(/[^0-9]/g, '');
                if (finalValue) {
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 50);
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            stat.textContent = stat.textContent.replace(finalValue, finalValue);
                            clearInterval(timer);
                        } else {
                            stat.textContent = stat.textContent.replace(/[0-9]+/, currentValue);
                        }
                    }, 30);
                }
            });
        };

        // Observer pour les stats
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const heroStats = document.querySelector('.hero-stats');
        if (heroStats) {
            statsObserver.observe(heroStats);
        }
    </script>
@endsection
