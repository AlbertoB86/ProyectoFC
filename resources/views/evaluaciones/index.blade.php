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
