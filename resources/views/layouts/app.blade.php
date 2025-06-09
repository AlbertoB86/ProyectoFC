<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mi Aplicación')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    @if (!request()->cookie('cookies_accepted'))
        <div id="cookie-banner" style="position:fixed;bottom:0;left:0;width:100%;background:#222;color:#fff;padding:15px;z-index:9999;text-align:center;">
            Usamos cookies para mejorar tu experiencia.
            <button onclick="acceptCookies()" class="btn btn-success btn-sm ms-2">Aceptar</button>
        </div>
        <script>
            function acceptCookies() {
                document.cookie = "cookies_accepted=1; path=/; max-age=" + (60*60*24*365);
                document.getElementById('cookie-banner').style.display = 'none';
            }
        </script>
    @endif
</body>
</html>


