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
            background: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .caja {
            background-color: rgba(0, 0, 0, 0.65);
            padding: 3rem 2.5rem;
            border-radius: 18px;
            text-align: center;
            color: white;
            max-width: 500px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            /* Animación de entrada */
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            animation: fadeInUp 1s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .caja h1 {
            letter-spacing: 2px;
            font-size: 2.3rem;
            margin-bottom: 0.5rem;
        }
        .caja p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .caja a {
            margin: 0 10px;
            padding: 12px 28px;
            font-weight: bold;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1.1rem;
            border: none;
            outline: none;
            display: inline-block;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(48,139,180,0.10);
        }
        .btn-login {
            background-color: #308bb4;
            color: white;
        }
        .btn-login:hover {
            background: #4888a5;
            color: #fff;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .btn-register {
            background: transparent;
            color: white;
            border: 1.5px solid white;
        }
        .btn-register:hover {
            background: white;
            color: #308bb4;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .caja.fade-out {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: opacity 0.5s, transform 0.5s;
        }
    </style>
</head>
<body>
    <div class="caja" id="cajaAnimada">
        <h1>APP Escalada</h1>
        <p>Tu herramienta de entrenamiento personalizada para escalar más alto.</p>
        @if (Route::has('login')) 
            <a href="{{ route('login') }}" class="btn-login transicion">Inicio Sesión</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-register transicion">Regístrate</a>
            @endif                
        @endif
    </div>
    <script>
        // Transición al pulsar los botones
        document.querySelectorAll('.transicion').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const caja = document.getElementById('cajaAnimada');
                caja.classList.add('fade-out');
                setTimeout(() => {
                    window.location.href = this.href;
                }, 500); // Debe coincidir con el tiempo del transition
            });
        });
    </script>
</body>
</html>