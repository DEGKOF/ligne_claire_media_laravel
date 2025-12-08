<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
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
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">Ligne Claire Média+</h1>
        <p style="margin: 10px 0 0 0;">Newsletter</p>
    </div>

    <div class="content">
        {!! $content !!}
    </div>

    <div class="footer">
        <p>Vous recevez cet email car vous êtes abonné à notre newsletter.</p>
        @if(isset($unsubscribeUrl))
            <p>
                <a href="{{ $unsubscribeUrl }}" style="color: #6b7280;">Se désabonner</a>
            </p>
        @endif
        <p>&copy; {{ date('Y') }} Ligne Claire Média+. Tous droits réservés.</p>
    </div>
</body>
</html>
