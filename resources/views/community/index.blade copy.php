<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCM Communauté — La voix des contributeurs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --comm-blue: #0C2D57;
            --comm-blue-2: #184178;
            --comm-blue-light: #2563b8;
            --comm-accent: #FFD54F;
            --comm-bg: #f6f8fb;
            --comm-text: #1f2630;
            --comm-muted: #6c7a8a;
            --comm-ok: #2fa66a;
            --comm-warn: #ff9f40;
            --comm-danger: #e05263;
            --comm-border: #e7edf5;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--comm-bg);
            color: var(--comm-text);
            line-height: 1.6;
        }

        .lcm-community-wrapper {
            padding: 60px 0;
            background: linear-gradient(180deg, #f6f8fb 0%, #ffffff 100%);
        }

        .lcm-community-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Hero Section */
        .lcm-community-hero {
            background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
            padding: 80px 40px;
            border-radius: 24px;
            margin-bottom: 60px;
            border: 1px solid var(--comm-border);
            box-shadow: 0 10px 40px rgba(12, 45, 87, 0.06);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .lcm-community-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(12, 45, 87, 0.03) 0%, transparent 70%);
            transition: all 0.6s ease;
        }

        .lcm-community-hero:hover::before {
            transform: scale(1.2);
        }

        .lcm-community-hero:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(12, 45, 87, 0.12);
        }

        .lcm-community-hero h1 {
            font-size: 42px;
            color: var(--comm-blue);
            margin-bottom: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            position: relative;
        }

        .lcm-community-hero h2 {
            font-size: 26px;
            color: var(--comm-blue-2);
            margin: 24px 0 20px;
            font-weight: 600;
        }

        .lcm-community-hero p {
            font-size: 18px;
            color: #425060;
            max-width: 900px;
            margin: 0 auto 20px;
            line-height: 1.8;
        }

        /* Mission Box */
        .mission-box {
            background: linear-gradient(135deg, #e8f1ff 0%, #f0f6ff 100%);
            border-left: 5px solid var(--comm-blue);
            border-radius: 16px;
            padding: 32px;
            margin: 32px auto;
            max-width: 900px;
            text-align: left;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .mission-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .mission-box:hover {
            transform: translateX(8px);
            box-shadow: -8px 8px 24px rgba(12, 45, 87, 0.1);
        }

        .mission-box:hover::after {
            opacity: 1;
        }

        .mission-box h3 {
            color: var(--comm-blue);
            margin: 0 0 16px;
            font-size: 20px;
            font-weight: 700;
        }

        .mission-box p {
            margin: 0 0 16px;
            line-height: 1.8;
        }

        .mission-box p:last-child {
            margin: 0;
        }

        /* Submit Button */
        .lcm-comm-submit-btn {
            display: inline-block;
            background: var(--comm-blue);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-top: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(12, 45, 87, 0.2);
            position: relative;
            overflow: hidden;
        }

        .lcm-comm-submit-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .lcm-comm-submit-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .lcm-comm-submit-btn:hover {
            background: var(--comm-blue-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(12, 45, 87, 0.3);
        }

        .lcm-comm-submit-btn:active {
            transform: translateY(-1px);
        }

        /* Panel */
        .panel {
            background: white;
            border: 1px solid var(--comm-border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(12, 45, 87, 0.06);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(12, 45, 87, 0.03), transparent);
            transition: left 0.6s ease;
        }

        .panel:hover::before {
            left: 100%;
        }

        .panel:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(12, 45, 87, 0.12);
        }

        .panel h2 {
            color: var(--comm-blue);
            margin: 0 0 24px;
            font-size: 28px;
            font-weight: 700;
        }

        .panel ul {
            margin: 0 0 24px 24px;
            padding-left: 0;
            line-height: 2;
        }

        .panel li {
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .panel li:hover {
            transform: translateX(8px);
            color: var(--comm-blue);
        }

        /* Offers Grid */
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .offer-card {
            background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
            border: 1px solid var(--comm-border);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .offer-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(12, 45, 87, 0.05) 0%, transparent 70%);
            transform: scale(0);
            transition: transform 0.6s ease;
        }

        .offer-card:hover::after {
            transform: scale(2);
        }

        .offer-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 48px rgba(12, 45, 87, 0.15);
            border-color: var(--comm-blue);
        }

        .offer-card h3 {
            color: var(--comm-blue);
            margin: 0 0 12px;
            font-size: 18px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .offer-card p {
            margin: 0;
            color: var(--comm-muted);
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        /* Steps */
        .steps-grid {
            display: grid;
            gap: 20px;
        }

        .step-item {
            display: flex;
            gap: 20px;
            align-items: start;
            padding: 24px;
            background: linear-gradient(135deg, #fafcff 0%, #ffffff 100%);
            border-radius: 14px;
            border-left: 4px solid var(--comm-blue);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .step-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 0;
            background: var(--comm-blue-light);
            transition: height 0.4s ease;
        }

        .step-item:hover::before {
            height: 100%;
        }

        .step-item:hover {
            transform: translateX(12px);
            background: linear-gradient(135deg, #e8f1ff 0%, #f0f6ff 100%);
            box-shadow: 0 8px 24px rgba(12, 45, 87, 0.1);
        }

        .step-number {
            background: var(--comm-blue);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .step-item:hover .step-number {
            transform: scale(1.15) rotate(360deg);
            background: var(--comm-blue-light);
        }

        .step-content h3 {
            margin: 0 0 6px;
            color: var(--comm-blue);
            font-size: 17px;
            font-weight: 700;
        }

        .step-content p {
            margin: 0;
            color: var(--comm-muted);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--comm-blue) 0%, var(--comm-blue-2) 100%);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            margin-bottom: 60px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .cta-section:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 60px rgba(12, 45, 87, 0.3);
        }

        .cta-section h2 {
            margin: 0 0 20px;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .cta-section p {
            margin: 0 0 12px;
            font-size: 16px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 32px;
            position: relative;
            z-index: 1;
        }

        .btn-white {
            background: white;
            color: var(--comm-blue);
            border: none;
        }

        .btn-white:hover {
            background: #f0f7ff;
            color: var(--comm-blue-2);
        }

        .btn-outline {
            background: rgba(255,255,255,0.15);
            border: 2px solid white;
            color: white;
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.25);
        }

        /* Submissions Grid */
        .lcm-submissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 28px;
            margin: 50px 0;
        }

        .lcm-submission-card {
            background: white;
            border: 1px solid var(--comm-border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .lcm-submission-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(12, 45, 87, 0.03) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .lcm-submission-card:hover::before {
            opacity: 1;
        }

        .lcm-submission-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 50px rgba(12, 45, 87, 0.15);
            border-color: var(--comm-blue);
        }

        .lcm-submission-thumb {
            height: 200px;
            background: linear-gradient(135deg, #dfe8f5 0%, #e8f1ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5e738f;
            font-weight: 700;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .lcm-submission-card:hover .lcm-submission-thumb {
            transform: scale(1.08);
        }

        .lcm-submission-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .lcm-submission-card:hover .lcm-submission-thumb img {
            transform: scale(1.1);
        }

        .lcm-submission-body {
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .lcm-submission-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lcm-submission-section,
        .lcm-submission-access,
        .lcm-submission-status {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .lcm-submission-section {
            background: var(--comm-bg);
            color: #4a596d;
        }

        .lcm-submission-card:hover .lcm-submission-section {
            background: var(--comm-blue);
            color: white;
            transform: scale(1.05);
        }

        .lcm-submission-access.free {
            color: var(--comm-ok);
            background: #e8f5f0;
        }

        .lcm-submission-access.premium {
            color: #b25b00;
            background: #fff4e6;
        }

        .lcm-submission-card h3 {
            font-size: 18px;
            margin: 0 0 12px;
            color: var(--comm-text);
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .lcm-submission-card:hover h3 {
            color: var(--comm-blue);
        }

        .section-title {
            color: var(--comm-blue);
            margin: 0 0 32px;
            font-size: 32px;
            font-weight: 700;
            text-align: center;
        }

        /* Info Box */
        .info-box {
            background: #e8f5f0;
            border-left: 5px solid var(--comm-ok);
            border-radius: 16px;
            padding: 24px;
            margin-top: 32px;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateX(8px);
            box-shadow: -8px 8px 24px rgba(47, 166, 106, 0.1);
        }

        .quote-box {
            background: linear-gradient(135deg, #f8fbff 0%, #e8f1ff 100%);
            border-radius: 16px;
            padding: 32px;
            margin-top: 32px;
            text-align: center;
            transition: all 0.4s ease;
        }

        .quote-box:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 36px rgba(12, 45, 87, 0.1);
        }

        .quote-box p:first-child {
            margin: 0;
            font-style: italic;
            color: var(--comm-blue-2);
            font-size: 18px;
            font-weight: 600;
            line-height: 1.6;
        }

        .quote-box p:last-child {
            margin: 12px 0 0;
            color: var(--comm-muted);
            font-size: 14px;
        }

        /* Spacing */
        .section-spacing {
            margin-bottom: 60px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .lcm-community-hero {
                padding: 60px 24px;
            }

            .lcm-community-hero h1 {
                font-size: 32px;
            }

            .lcm-community-hero h2 {
                font-size: 22px;
            }

            .panel {
                padding: 28px;
            }

            .lcm-submissions-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-section {
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="lcm-community-wrapper">
        <div class="lcm-community-container">
            <!-- Hero -->
            <div class="lcm-community-hero">
                <h1>LCM Communauté — La voix des contributeurs</h1>
                <h2>Renforcer un journalisme indépendant</h2>
                <p><strong>LCM Communauté</strong> est une initiative au service du journalisme libre, de l'engagement citoyen et du pluralisme médiatique.</p>
                <p>À l'intersection des médias, du numérique et de la société civile, nous soutenons toutes celles et ceux qui s'engagent à produire une information rigoureuse, inclusive et indépendante.</p>

                <div class="mission-box">
                    <h3>Donner la parole à ceux qui pensent, agissent et observent</h3>
                    <p>LCM Communauté est l'espace participatif de LCM Media, ouvert aux journalistes indépendants, auteurs, universitaires, experts et citoyens engagés désireux de partager leurs analyses, opinions et tribunes.</p>
                    <p>Nous croyons qu'une information plurielle, libre et éclairée se construit ensemble, au-delà des structures éditoriales traditionnelles. Chaque voix compte, chaque regard enrichit le débat public.</p>
                </div>

                <button class="lcm-comm-submit-btn">Soumettre un article</button>
            </div>

            <!-- Notre Ambition -->
            <div class="section-spacing">
                <div class="panel">
                    <h2>Notre ambition</h2>
                    <p>Nous œuvrons pour une presse véritablement <strong>indépendante et durable</strong>, en accompagnant les acteurs médiatiques sur :</p>
                    <ul>
                        <li>le <strong>plan éditorial</strong>, pour garantir la qualité et la vérification des contenus</li>
                        <li>le <strong>plan économique</strong>, pour bâtir des modèles viables et transparents</li>
                        <li>le <strong>plan managérial</strong>, pour structurer les rédactions</li>
                        <li>et le <strong>plan technique</strong>, en intégrant les outils numériques et les nouvelles technologies du journalisme</li>
                    </ul>
                    <p style="margin-top: 24px; font-size: 17px;"><strong>Notre objectif : donner les moyens de durer à ceux qui informent librement.</strong></p>

                    <div class="quote-box">
                        <p>"Informer, c'est exercer un acte de liberté.<br>LCM Communauté existe pour la protéger."</p>
                        <p>— LCM Média</p>
                    </div>
                </div>
            </div>

            <!-- Ce que nous offrons -->
            <div class="section-spacing">
                <div class="panel">
                    <h2>Ce que nous offrons</h2>
                    <p style="margin-bottom: 28px;">Un espace numérique moderne, simple et transparent où :</p>

                    <div class="offers-grid">
                        <div class="offer-card">
                            <h3>Publication</h3>
                            <p>Chaque contributeur peut <strong>publier</strong> des articles ou analyses (après validation éditoriale)</p>
                        </div>
                        <div class="offer-card">
                            <h3>Rémunération</h3>
                            <p>Certains contenus sont <strong>gratuits</strong>, d'autres <strong>premium</strong>, rémunérant directement l'auteur</p>
                        </div>
                        <div class="offer-card">
                            <h3>Soutien</h3>
                            <p>Les lecteurs peuvent <strong>soutenir les journalistes indépendants</strong> via un système de dons ou d'abonnement</p>
                        </div>
                        <div class="offer-card">
                            <h3>Transparence</h3>
                            <p>LCM Plus assure la <strong>modération, la mise en forme et la visibilité</strong> sur le site et les réseaux</p>
                        </div>
                    </div>

                    <div class="info-box">
                        <p style="margin: 0; line-height: 1.8;">Chaque auteur dispose d'un <strong>tableau de bord</strong> pour suivre ses statistiques : lectures, soutiens, revenus, feedbacks.</p>
                    </div>
                </div>
            </div>

            <!-- Comment ça marche -->
            <div class="section-spacing">
                <div class="panel">
                    <h2>Comment ça marche ?</h2>
                    <div class="steps-grid">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3>Inscription & validation</h3>
                                <p>du profil contributeur</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>Soumission d'un article</h3>
                                <p>(texte, images, sources, etc.)</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3>Relecture éditoriale</h3>
                                <p>par l'équipe de LCM</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h3>Publication</h3>
                                <p>sur la plateforme</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <h3>Rémunération</h3>
                                <p>selon le modèle (gratuit / premium)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="cta-section">
                <h2>LCM Communauté — La voix des contributeurs</h2>
                <p>Publiez vos articles, analyses et tribunes sur la première plateforme béninoise d'expression journalistique indépendante.</p>
                <div style="margin-top: 28px;">
                    <p>Participez au débat.</p>
                    <p>Faites entendre votre point de vue.</p>
                    <p>Recevez une part des revenus de vos publications.</p>
                </div>
                <div class="cta-buttons">
                    <button class="lcm-comm-submit-btn btn-white">Rejoindre LCM Communauté</button>
                    <a href="#published-articles" class="lcm-comm-submit-btn btn-outline">Découvrir les articles publiés</a>
                </div>
            </div>

            <!-- Articles publiés -->
            <h2 class="section-title" id="published-articles">Articles publiés par la communauté</h2>
            <div class="lcm-submissions-grid">
                <!-- Example Card 1 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Société</span>
                            <span class="lcm-submission-access free">Gratuit</span>
                        </div>
                        <h3>L'éducation numérique au Bénin : défis et opportunités</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Marie Akouété</strong> • Cotonou</p>
                    </div>
                </article>

                <!-- Example Card 2 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Économie</span>
                            <span class="lcm-submission-access premium">Premium</span>
                        </div>
                        <h3>Les startups béninoises face au défi du financement</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Jean Kpohinto</strong> • Porto-Novo</p>
                    </div>
                </article>

                <!-- Example Card 3 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Tech & IA</span>
                            <span class="lcm-submission-access free">Gratuit</span>
                        </div>
                        <h3>Intelligence artificielle et agriculture : l'avenir de la production alimentaire</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Rachid Fassinou</strong> • Parakou</p>
                    </div>
                </article>

                <!-- Example Card 4 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Environnement</span>
                            <span class="lcm-submission-access free">Gratuit</span>
                        </div>
                        <h3>Préservation des mangroves : enjeux écologiques et économiques</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Sylvie Dossou</strong> • Ouidah</p>
                    </div>
                </article>

                <!-- Example Card 5 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Culture</span>
                            <span class="lcm-submission-access premium">Premium</span>
                        </div>
                        <h3>Le cinéma béninois à l'ère du numérique : renaissance ou mutation ?</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Fabrice Adjovi</strong> • Cotonou</p>
                    </div>
                </article>

                <!-- Example Card 6 -->
                <article class="lcm-submission-card">
                    <div class="lcm-submission-thumb">
                        <div style="font-size: 18px;">Image d'article</div>
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">Investigation</span>
                            <span class="lcm-submission-access premium">Premium</span>
                        </div>
                        <h3>Corruption dans les marchés publics : enquête sur les zones d'ombre</h3>
                        <p style="color: var(--comm-muted); font-size: 14px;">par <strong>Sébastien Agbodji</strong> • Cotonou</p>
                    </div>
                </article>
            </div>

            <!-- Footer Note -->
            <div style="text-align: center; padding: 40px 0; color: var(--comm-muted);">
                <p style="font-size: 15px; margin: 0;">Rejoignez des centaines de contributeurs qui font vivre le journalisme indépendant au Bénin</p>
                <p style="font-size: 14px; margin: 12px 0 0;">Une initiative <strong style="color: var(--comm-blue);">LCM Media</strong></p>
            </div>
        </div>
    </div>

    <script>
        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Appliquer l'animation aux cartes
        document.querySelectorAll('.lcm-submission-card, .panel, .offer-card, .step-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Effet parallaxe léger sur le hero
        window.addEventListener('scroll', () => {
            const hero = document.querySelector('.lcm-community-hero');
            const scrolled = window.pageYOffset;
            if (hero && scrolled < 600) {
                hero.style.transform = `translateY(${scrolled * 0.3}px)`;
                hero.style.opacity = 1 - (scrolled * 0.001);
            }
        });

        // Gestion des boutons
        document.querySelectorAll('.lcm-comm-submit-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!this.getAttribute('href')) {
                    e.preventDefault();
                    alert('Formulaire de soumission (à intégrer avec votre backend Laravel)');
                }
            });
        });

        // Animation des chiffres (si vous avez des statistiques)
        const animateValue = (element, start, end, duration) => {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.textContent = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        };

        // Effet de typing sur le titre (optionnel)
        const typeWriter = (element, text, speed = 50) => {
            let i = 0;
            element.textContent = '';
            const type = () => {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            };
            type();
        };
    </script>
</body>
</html>
