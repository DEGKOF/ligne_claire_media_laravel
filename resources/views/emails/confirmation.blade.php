<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .unsubscribe {
            color: #999;
            font-size: 11px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Bienvenue !</h1>
    </div>

    <div class="content">
        <h2>Merci pour votre inscription</h2>
        <p>Bonjour,</p>
        <p>Nous vous confirmons votre inscription à notre newsletter avec l'adresse : <strong>{{ $email }}</strong></p>
        <p>Vous recevrez désormais nos actualités, offres exclusives et contenus directement dans votre boîte mail.</p>
        <p>Si vous n'êtes pas à l'origine de cette inscription, vous pouvez ignorer cet email.</p>
    </div>

    <div class="footer">
        <p class="unsubscribe">
            Vous ne souhaitez plus recevoir nos emails ?
            <a href="{{ $unsubscribeUrl }}" style="color: #666;">Se désabonner</a>
        </p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
    </div>
</body>
</html>
