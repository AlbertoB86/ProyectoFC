@extends('adminlte::page')

@section('title', 'APP Climbing | Ejercicios')

@section('content_header')
    {{ auth()->user()->name }}{{ auth()->user()->rol == 'admin' ? ' (Admin)' : '' }}    
@stop

@section('content')
    <h1>Ejercicios</h1>

    @if (session('error'))
        <div class="d-flex justify-content-center mt-3">
            <div class="col-lg-4">
                <div class="alert alert-danger text-center d-flex align-items-center justify-content-center">
                    {{ session('error') }} 
                </div>
            </div>
        </div>
    @endif

    <a href="{{ route('ejercicios.create') }}" class="btn" style="background-color:rgb(108, 188, 140); color:rgb(49, 87, 68)">Añadir  Ejercicio</a>

    <table id="ejercicios" class="table is-striped" style="width:100%; ; margin-bottom: 20px;">
        <thead>
            <tr class="table-light">
                <th>ID</th>
                <th>Tipo</th>
                <th style="width: 20%;">Ejercicio</th>
                <th style="width: 30%;">Descripción</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
        </thead>    
        <tbody>
            @foreach ($ejercicios as $ejercicio)
            <tr class="table-light">
                <td>{{$ejercicio->id}}</td>
                <td>{{ $ejercicio->tipo }}</td>
                <td>{{ $ejercicio->nombre }}</td>
                <td>{{ $ejercicio->descripcion }}</td>
                <td>{{ $ejercicio->nivel }}</td>
                <td>
                    <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn" style="background-color: rgb(108, 188, 140); color:rgb(49, 87, 68)">Editar</a>
                    <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminarlo?');">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
            background: linear-gradient(120deg, rgb(108, 188, 140) 0%, #1e3c72 100%) !important;
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
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            $('#ejercicios').DataTable({
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