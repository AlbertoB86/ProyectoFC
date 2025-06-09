<div id="cookie-consent" class="shadow-lg rounded-3" style="display: none; position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); min-width: 340px; max-width: 90vw; background: #222; color: #fff; padding: 1.5rem 2rem; z-index: 2000; text-align: center;">
    <p class="mb-3">
        Esta web utiliza cookies para mejorar la experiencia. Puedes aceptarlas todas o configurar tus preferencias.
    </p>
    <div class="d-flex justify-content-center gap-3 mb-2">
        <button onclick="aceptarTodasCookies()" class="btn btn-success btn-sm" style="margin: 5px">Aceptar todas</button>
        <button onclick="mostrarConfiguracion()" class="btn btn-outline-light btn-sm" style="margin: 5px">Configurar</button>
    </div>
</div>

<div id="configuracion-cookies" class="shadow-lg rounded-3" style="display: none; position: fixed; bottom: 20%; left: 50%; transform: translateX(-50%); background: #fff; color: #222; padding: 2rem 2.5rem; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.3); z-index: 2001; min-width: 320px; max-width: 95vw;">
    <h5 class="mb-3">Configuración de Cookies</h5>
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" disabled checked id="tecnicas">
        <label class="form-check-label" for="tecnicas">Cookies técnicas (obligatorias)</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" id="analiticas">
        <label class="form-check-label" for="analiticas">Cookies analíticas</label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="funcionales">
        <label class="form-check-label" for="funcionales">Cookies funcionales</label>
    </div>
    <div class="d-flex justify-content-center gap-2">
        <button onclick="guardarConfiguracionCookies()" class="btn btn-primary btn-sm">Guardar configuración</button>
        <button onclick="cerrarConfiguracion()" class="btn btn-secondary btn-sm">Cancelar</button>
    </div>
</div>

<script>
    function mostrarConfiguracion() {
        document.getElementById('configuracion-cookies').style.display = 'block';
    }

    function cerrarConfiguracion() {
        document.getElementById('configuracion-cookies').style.display = 'none';
    }

    function aceptarTodasCookies() {
        localStorage.setItem('cookies_aceptadas', 'true');
        localStorage.setItem('cookies_analiticas', 'true');
        localStorage.setItem('cookies_funcionales', 'true');
        document.getElementById('cookie-consent').style.display = 'none';
    }

    function guardarConfiguracionCookies() {
        const analiticas = document.getElementById('analiticas').checked;
        const funcionales = document.getElementById('funcionales').checked;
        localStorage.setItem('cookies_aceptadas', 'true');
        localStorage.setItem('cookies_analiticas', analiticas);
        localStorage.setItem('cookies_funcionales', funcionales);
        cerrarConfiguracion();
        document.getElementById('cookie-consent').style.display = 'none';
    }

    window.addEventListener('load', function () {
        if (!localStorage.getItem('cookies_aceptadas')) {
            document.getElementById('cookie-consent').style.display = 'block';
        }
    });
</script>