@extends('adminlte::page')

@section('title', 'APP Climbing | Mis Planes de Entrenamiento')

@section('content_header')
    <h1>{{ $user->name ?? 'Sin usuario' }} {{ $user->primer_apellido ?? '' }} {{ $user->segundo_apellido ?? '' }}</h1>
@stop

@section('content')
    <h1>Mis Planes de Entrenamiento</h1>

    @if (session('error'))
        <div class="d-flex justify-content-center mt-3">
            <div class="col-lg-4">
                <div class="alert alert-danger text-center d-flex align-items-center justify-content-center">
                    {{ session('error') }} 
                </div>
            </div>
        </div>
    @endif

    @if($planesEntrenamiento->isEmpty())
        <p>No tienes planes de entrenamiento registrados.</p>
    @else
        <table id="entrenamientos" class="table mt-4" style="text-align: center; margin-bottom: 20px;">
            <thead>
                <tr class="table-light">
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Nivel</th>
                    <th class="text-center">Fecha de Inicio</th>
                    <th class="text-center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($planesEntrenamiento as $plan)
                    <tr class="table-light">
                        <td class="text-start">{{ $plan->nombre }}</td>
                        <td>{{ $plan->nivel }}</td>
                        <td>{{ \Carbon\Carbon::parse($plan->fecha_inicio)->translatedFormat('j \d\e F \d\e Y') }}</td>                                                
                        <td>
                            @if($plan->completado)
                                Completado
                            @elseif($plan->iniciado)
                                En progreso
                            @else
                                No iniciado
                            @endif
                        </td>
                        <td><a href="{{ route('planEntrenamiento.pdf') }}">Descargar PDF</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Footer -->
    <hr style="border: 1px solid rgba(11, 75, 112, 0.295); width: 100%; margin-top: 100px; margin-bottom: 25px;">
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
            $('#entrenamientos').DataTable({
                "order": [[ 2, "desc" ]],
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
