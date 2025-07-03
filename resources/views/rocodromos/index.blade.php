@extends('adminlte::page')

@section('title', 'APP Climbing | Rocódromos')

@section('content_header')
@stop

@section('content')
    <h1>Rocodromos</h1>

    @if (session('error'))
        <div class="d-flex justify-content-center mt-3">
            <div class="col-lg-4">
                <div class="alert alert-danger text-center d-flex align-items-center justify-content-center">
                    {{ session('error') }} 
                </div>
            </div>
        </div>
    @endif
    @if($rocodromos->isEmpty())
        <p>No hay rocódromos registrados.</p>
    @else
        <div class="d-flex justify-content-start mb-3">
            @if(auth()->user()->rol == 'admin')
                <a href="{{ route('rocodromos.create') }}" class="btn" style="background-color:rgb(108, 188, 140); color:rgb(49, 87, 68)">Añadir Rocódromo</a>
            @endif
        </div>
        <div class="row g-4 align-items-stretch">  
            <div class="row g-4 align-items-stretch">
                <!-- Mapa a la izquierda -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color:rgb(49, 87, 68); color: rgb(218, 188, 134);">
                            <i class="fas fa-map-marker-alt me-2"></i> Rocódromos Cercanos
                        </div>
                        <div class="card-body p-0">
                            <div id="mapa-rocodromos"></div>
                        </div>
                    </div>
                </div>
                <!-- Contenido nuevo a la derecha -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color:rgb(49, 87, 68); color: rgb(218, 188, 134);">
                            <i class="fas fa-filter me-2"></i> Buscar y Filtrar Rocódromos
                        </div>
                        <div class="card-body">
                            <!-- Filtros de búsqueda -->
                            <form method="GET" action="{{ route('rocodromos.index') }}">
                                <div class="mb-3">
                                    <label for="ciudad" class="form-label">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Buscar por ciudad" value="{{ request('ciudad') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="provincia" class="form-label">Provincia</label>
                                    <input type="text" name="provincia" id="provincia" class="form-control" placeholder="Buscar por provincia" value="{{ request('provincia') }}">
                                </div>
                                <button type="submit" class="btn" style="background-color:rgb(108, 188, 140); color:rgb(49, 87, 68)">Buscar</button>
                                <a href="{{ route('rocodromos.index') }}" class="btn" style="background-color:rgb(49, 87, 68); color: rgb(218, 188, 134)">Limpiar Filtros</a>
                            </form>
                            <hr>
                            <!-- Resumen rápido -->
                            <h5 class="mt-3">Total rocódromos: <span class="badge" style="background-color:rgb(108, 188, 140); color: rgb(49, 87, 68)">{{ $rocodromos->count() }}</span></h5>
                            <ul class="list-group mt-3">
                                @foreach($rocodromos->take(5) as $rocodromo)
                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                        {{ $rocodromo->nombre }}
                                        @if($rocodromo->web)
                                            <a href="{{ $rocodromo->web }}" target="_blank" title="Web"><i class="fas fa-globe"></i></a>                                            
                                        @endif
                                        @if($rocodromo->latitud && $rocodromo->longitud)
                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $rocodromo->latitud }},{{ $rocodromo->longitud }}" target="_blank" title="Cómo llegar">
                                                <i class="fas fa-directions"></i>
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header" style="background-color:rgb(49, 87, 68); color: rgb(218, 188, 134);">
                        <i class="fas fa-list me-2"></i> Lista de Rocódromos
                    </div>
                    <div class="card-body p-0 h-100">
                        <div class="table-responsive h-100">
                            <table id="rocodromos" class="table w-100 mb-0" style="text-align: center;">
                                <thead>
                                    <tr class="table-light">
                                        <th>Nombre</th>
                                        <th>Ciudad</th>
                                        <th>Provincia</th>
                                        <th>Teléfono</th>
                                        <th>Horario</th>
                                        <th>Web</th>
                                        @if(auth()->user()->rol == 'admin')
                                            <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rocodromos as $rocodromo)
                                        <tr class="table-light">
                                            <td>{{ $rocodromo->nombre }}</td>
                                            <td>{{ $rocodromo->ciudad }}</td>
                                            <td>{{ $rocodromo->provincia }}</td>
                                            <td>{{ $rocodromo->telefono }}</td>
                                            <td>{{ $rocodromo->horario }}</td>
                                            <td>
                                                @if($rocodromo->web)
                                                    <a href="{{ $rocodromo->web }}" target="_blank" title="Visitar web">
                                                        <i class="fas fa-globe fa-lg"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">No disponible</span>
                                                @endif
                                            </td>
                                            @if(auth()->user()->rol == 'admin')
                                                <td>
                                                    <a href="{{ route('rocodromos.edit', $rocodromo) }}" class="btn" style="background-color: rgb(108, 188, 140); color:rgb(49, 87, 68)">Editar</a>
                                                    <form action="{{ route('rocodromos.destroy', $rocodromo) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminarlo?');">Eliminar</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
        </div>  
    @endif

    <!-- Footer -->
    <hr style="border: 1px solid rgba(11, 75, 112, 0.295); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>    
    @include('components.cookies')    
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            background: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%) !important;
            min-height: 100vh;
        }
        .card, .info-box, .modal-content, .table, .alert, .btn {
            border-radius: 18px !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }
        .table {
            background-color: rgba(0,0,0,0.65) !important;
            color: #fff;
            animation: fadeInUp 1s ease forwards;
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            animation-fill-mode: forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .table th, .table td {
            vertical-align: middle !important;
            text-align: center;
        }
        .table th {
            background-color: #f8f9fa !important;
            color: #222 !important;
        }
        .btn, a.btn, .btn-success {
            font-weight: bold;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover, a.btn:hover, .btn-success:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .alert {
            background-color: rgba(0,0,0,0.65) !important;
            color: #fff !important;
        }
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            .table th, .table td {
                font-size: 12px;
                padding: 8px;
            }
        }
        #mapa-rocodromos {
            width: 100%;
            height: 500px;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        $(document).ready(function() {
            $('#rocodromos').DataTable({
                "lengthMenu": [5, 10, 20],
                "order": [[ 3, "asc" ]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });

        // Array de rocódromos desde PHP a JS
        const rocodromos = @json($rocodromos);

        // Inicializa el mapa
        var map = L.map('mapa-rocodromos').setView([40.4168, -3.7038], 6); // Centro inicial: España

        // Capa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Añade marcadores de rocódromos
        rocodromos.forEach(function(r) {
            if (r.latitud && r.longitud) {
                let gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${r.latitud},${r.longitud}`;
                let popupContent = `<b>${r.nombre}</b><br>${r.ciudad ?? ''}<br>
                    <a href="${gmapsUrl}" target="_blank" class="btn btn-sm btn mt-2">
                        Cómo llegar
                    </a>`;
                L.marker([parseFloat(r.latitud), parseFloat(r.longitud)])
                    .addTo(map)
                    .bindPopup(popupContent);
            }
        });

        // Geolocalización del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                // Marca tu posición
                L.marker([userLat, userLng], {icon: L.icon({iconUrl: 'https://cdn-icons-png.flaticon.com/512/64/64113.png', iconSize: [32,32]})})
                    .addTo(map)
                    .bindPopup('¡Estás aquí!');
                // Centra el mapa en tu posición
                map.setView([userLat, userLng], 11);
            });
        }
    </script>
@stop

