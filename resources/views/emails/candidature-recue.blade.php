<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réception</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 20px;
        }
        .message {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f0f7ff;
            border-left: 4px solid #2563eb;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #1e3a8a;
            font-size: 16px;
        }
        .info-item {
            margin: 10px 0;
            font-size: 14px;
        }
        .info-item strong {
            color: #1e3a8a;
            display: inline-block;
            width: 120px;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #2563eb;
            color: white;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .next-steps {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .next-steps h3 {
            margin: 0 0 15px 0;
            color: #92400e;
            font-size: 16px;
        }
        .next-steps ul {
            margin: 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 8px 0;
            color: #78350f;
            font-size: 14px;
        }
        .footer {
            background-color: #1f2937;
            color: #9ca3af;
            padding: 30px;
            text-align: center;
            font-size: 13px;
        }
        .footer a {
            color: #60a5fa;
            text-decoration: none;
        }
        .signature {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-style: italic;
            color: #6b7280;
        }
        .emoji {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Candidature Reçue !</h1>
            <p>LIGNE CLAIRE MÉDIA+</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Bonjour {{ $candidature->prenom }} {{ $candidature->nom }},
            </div>

            <div class="message">
                Nous avons bien reçu votre candidature pour le poste de <span class="badge">{{ $candidature->poste_libelle }}</span>
                et nous vous en remercions sincèrement.
            </div>

            <div class="message">
                Votre profil a retenu notre attention et nous allons l'examiner avec le plus grand soin.
            </div>

            <!-- Récapitulatif -->
            <div class="info-box">
                <h3>Récapitulatif de votre candidature</h3>
                <div class="info-item">
                    <strong>Nom complet :</strong> {{ $candidature->prenom }} {{ $candidature->nom }}
                </div>
                <div class="info-item">
                    <strong>Email :</strong> {{ $candidature->email }}
                </div>
                <div class="info-item">
                    <strong>Téléphone :</strong> {{ $candidature->telephone }}
                </div>
                <div class="info-item">
                    <strong>Poste :</strong> {{ $candidature->poste_libelle }}
                </div>
                <div class="info-item">
                    <strong>Date de soumission :</strong> {{ $candidature->created_at->format('d/m/Y à H:i') }}
                </div>
                <div class="info-item">
                    <strong>CV :</strong> ✓ Reçu
                </div>
                <div class="info-item">
                    <strong>Lettre de motivation :</strong>
                    @if($candidature->hasLettreTexte())
                        ✓ Reçue (texte)
                    @else
                        ✓ Reçue (fichier)
                    @endif
                </div>
            </div>

            <!-- Prochaines étapes -->
            <div class="next-steps">
                <h3>Prochaines étapes</h3>
                <ul>
                    <li>Notre équipe RH va examiner votre candidature dans les <strong>7 jours ouvrés</strong>.</li>
                    <li>Si votre profil correspond à nos besoins, nous vous contacterons par email ou téléphone.</li>
                    <li>Nous conservons votre candidature pendant <strong>6 mois</strong> pour d'autres opportunités.</li>
                </ul>
            </div>

            <div class="message">
                En attendant, n'hésitez pas à suivre notre actualité et à découvrir notre univers sur notre site web.
            </div>

            <div class="signature">
                Cordialement,<br>
                <strong>L'équipe Recrutement</strong><br>
                LIGNE CLAIRE MÉDIA+
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>LIGNE CLAIRE MÉDIA+</strong><br>
                L'information en continu
            </p>
            <p style="margin-top: 20px;">
                <a href="{{ route('home') }}">Visiter notre site</a> •
                <a href="{{ route('recruitment.index') }}">Autres offres d'emploi</a>
            </p>
            <p style="margin-top: 20px; font-size: 11px;">
                Cet email de confirmation automatique ne nécessite pas de réponse.<br>
                Si vous avez des questions, veuillez nous contacter via notre site web.
            </p>
            <p style="margin-top: 15px; color: #6b7280;">
                © {{ date('Y') }} LIGNE CLAIRE MÉDIA+ - Tous droits réservés
            </p>
        </div>
    </div>
</body>
</html>
