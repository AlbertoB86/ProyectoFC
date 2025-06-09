<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a APP Escalada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .caja {
            background-color: rgba(0, 0, 0, 0.486);
            padding: 3rem;
            border-radius: 12px;
            text-align: center;
            color: white;
            max-width: 500px;
        }
        .caja p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .caja a {
            margin: 0 10px;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 4px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #4888a5;
        }
        .btn-register:hover {
            background-color: white;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="caja">
        <h1>APP Escalada</h1>
        <p>Tu herramienta de entrenamiento personalizada para escalar más alto.</p>
        @if (Route::has('login')) 
            <a href="{{ route('login') }}" style="background-color: #308bb4; color:white">Inicio Sesión</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="background-color:transparent; color: white; border: 1px solid white">Registrate</a>
            @endif                
        @endif
    </div>
</body>
</html>