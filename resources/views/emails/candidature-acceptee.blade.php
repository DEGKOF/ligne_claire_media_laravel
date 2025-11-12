<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidature acceptée</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="margin: 0; font-size: 28px;">🎉 Félicitations !</h1>
    </div>

    <div style="background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            Bonjour <strong>{{ $candidature->prenom }} {{ $candidature->nom }}</strong>,
        </p>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Nous avons le plaisir de vous informer que votre candidature pour le poste de
            <strong>{{ ucfirst($candidature->poste) }}</strong> a été <span style="color: #10b981; font-weight: bold;">acceptée</span> !
        </p>

        <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 15px;">
                ✅ Votre profil correspond parfaitement aux attentes de LIGNE CLAIRE MÉDIA+ et nous serions ravis de vous compter parmi notre équipe.
            </p>
        </div>

        <h3 style="color: #1f2937; margin-top: 30px;">Prochaines étapes :</h3>
        <ul style="font-size: 15px; line-height: 1.8;">
            <li>Un membre de notre équipe RH vous contactera dans les prochains jours</li>
            <li>Nous fixerons ensemble une date pour finaliser les modalités</li>
            <li>Vous recevrez toutes les informations nécessaires pour votre intégration</li>
        </ul>

        <p style="font-size: 16px; margin-top: 30px;">
            En attendant, si vous avez des questions, n'hésitez pas à nous contacter par email.
        </p>

        <p style="font-size: 16px; margin-top: 30px;">
            Bienvenue dans l'équipe !
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
