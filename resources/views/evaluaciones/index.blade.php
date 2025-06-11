@extends('adminlte::page')

@section('title', 'APP Climbing | Mis Evaluaciones')

@section('content_header')
    <h1>{{ $user->name ?? 'Sin usuario' }} {{ $user->primer_apellido ?? '' }} {{ $user->segundo_apellido ?? '' }}</h1>
@stop

@section('content')
    <h1>Mis Evaluaciones</h1>

    @if (session('error'))
        <div class="d-flex justify-content-center mt-3">
            <div class="col-lg-4">
                <div class="alert alert-danger text-center d-flex align-items-center justify-content-center">
                    {{ session('error') }} 
                </div>
            </div>
        </div>
    @endif

    <a href="{{ route('evaluaciones.create') }}" class="btn" style="background-color: rgb(51, 125, 148); color:blanchedalmond">Realizar Nueva Evaluación</a>
    @if($evaluaciones->isEmpty())
        <p style="margin: 10px">No tienes ninguna evaluación registrada</p>
    @else
        <table id="evaluaciones" class="table mt-4" style="text-align: center; margin-bottom: 20px;">
            <thead>
                <tr class="table-light">
                    <th>Fecha</th>
                    <th>Nivel</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Dominadas al Fallo</th>
                    <th>Flexiones al Fallo</th>
                    <th>Tiempo Regleta de 40mm</th>
                    <th>Regleta Mínima durante 10 Seg</th>
                    <th>Nivel máximo de Bloque</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluaciones as $evaluacion)
                <tr class="table-light">
                    <td data-order="{{ \Carbon\Carbon::parse($evaluacion->fecha)->format('Y-m-d') }}">{{ \Carbon\Carbon::parse($evaluacion->fecha)->format('d-m-Y') }}</td>
                    <td>{{ $evaluacion->nivel }}</td>
                    <td>{{ $evaluacion->peso }} kg</td>
                    <td>{{ $evaluacion->altura }} cm</td>
                    <td>{{ $evaluacion->dominadas_fallo }}</td>
                    <td>{{ $evaluacion->flexiones_fallo }}</td>
                    <td>{{ $evaluacion->max_tiempo_regleta_40mm }} seg</td>
                    <td>{{ $evaluacion->minima_regleta_10seg }} mm</td>
                    <td>{{ $evaluacion->bloque_max }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
        .btn {
            font-weight: bold;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .alert {
            background-color: rgba(243, 43, 7, 0.65) !important;
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
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            $('#evaluaciones').DataTable({
                "order": [[0, "desc"]],
                "lengthMenu": [5, 10, 20],
                "columnDefs": [
                    { "className": "text-center", "targets": "_all" }
                ],
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
    </script>
@stop
