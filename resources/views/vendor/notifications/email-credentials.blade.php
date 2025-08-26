<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ config('app.name') }}</title>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
        }
        .header {
            background-color: #1B5E20;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .important {
            background-color: #ffe6e6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            color: #721c24;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #1B5E20;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="header">
            ¡Bienvenido al Sistema de Control INCOS!
        </div>
        
        <div class="content">
            <p>Estimado(a) {{ $name }},</p>
            
            <p>Su cuenta ha sido creada exitosamente en nuestro sistema. A continuación, encontrará sus credenciales de acceso:</p>
            
            <div class="credentials">
                <p><strong>Correo electrónico:</strong> {{ $email }}</p>
                <p><strong>Contraseña temporal:</strong> {{ $password }}</p>
            </div>

            <div class="important">
                <strong>¡Importante!</strong>
                <p>Por motivos de seguridad, deberá cambiar esta contraseña en su primer inicio de sesión.</p>
            </div>

            <p>Para acceder al sistema, haga clic en el siguiente botón:</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Iniciar Sesión</a>
            </div>

            <p style="margin-top: 20px;">Si el botón no funciona, puede copiar y pegar el siguiente enlace en su navegador:</p>
            <p style="word-break: break-all;">{{ $url }}</p>
        </div>
    </div>
</body>
</html>
