<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre candidature</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="margin: 0; font-size: 28px;">LIGNE CLAIRE MÉDIA+</h1>
    </div>

    <div style="background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            Bonjour <strong>{{ $candidature->prenom }} {{ $candidature->nom }}</strong>,
        </p>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Nous vous remercions sincèrement pour l'intérêt que vous avez porté à LIGNE CLAIRE MÉDIA+
            et pour le temps consacré à votre candidature pour le poste de <strong>{{ ucfirst($candidature->poste) }}</strong>.
        </p>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Après un examen approfondi de votre profil, nous avons le regret de vous informer que
            nous ne pouvons pas donner une suite favorable à votre candidature pour ce poste à l'heure actuelle.
        </p>

        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 15px;">
                Cette décision n'enlève rien à la qualité de votre parcours. Nous avons simplement retenu
                des profils correspondant plus précisément aux exigences spécifiques du poste.
            </p>
        </div>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Nous vous encourageons vivement à postuler à nouveau lors de nos prochaines campagnes de recrutement.
            Votre CV restera dans notre base de données pour de futures opportunités qui pourraient correspondre
            à votre profil.
        </p>

        <p style="font-size: 16px; margin-top: 30px;">
            Nous vous souhaitons plein succès dans vos recherches professionnelles et dans vos projets futurs.
        </p>

        <p style="font-size: 16px; margin-top: 20px;">
            Cordialement,<br>
            <strong>L'équipe Recrutement de LIGNE CLAIRE MÉDIA+</strong>
        </p>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="font-size: 14px; color: #6b7280; margin: 5px 0;">
                <strong>LIGNE CLAIRE MÉDIA+</strong><br>
                L'info en continu
            </p>
            <p style="font-size: 13px; color: #9ca3af; margin: 5px 0;">
                Email : recrutement@ligneclairemedia.com<br>
                Tél : +229 XX XX XX XX
            </p>
        </div>
    </div>
</body>
</html>
