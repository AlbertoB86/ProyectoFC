@extends('adminlte::page')

@section('title', 'APP Escalada - Inicio')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-12 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4>
                <i class="fas fa-user-circle fa-3x me-2"></i>
                {{ auth()->user()->name }} {{ auth()->user()->primer_apellido }} {{ auth()->user()->segundo_apellido }}
            </h4>
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container">
    <div class="row g-4">
        <!-- Columna lateral -->
        <div class="col-lg-3 col-md-4">
            <div class="info-box mb-3 shadow rounded-3" style="background-color: rgba(241, 118, 29, 0.678)">
                <span class="info-box-icon"><i class="fas fa-mountain"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nivel Actual</span>
                    <span class="info-box-number fs-5">
                        @if(auth()->user()->ultimaEvaluacion)
                            {{ auth()->user()->ultimaEvaluacion->nivel }}
                        @else
                            Sin evaluar
                        @endif
                    </span>
                </div>
            </div>
            <div class="info-box mb-3 shadow rounded-3" style="background-color:rgba(67, 240, 78, 0.671)">
                <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Última Evaluación</span>
                    <span class="info-box-number fs-6">
                        @if(auth()->user()->ultimaEvaluacion)
                            {{ \Carbon\Carbon::parse(auth()->user()->ultimaEvaluacion->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        @else
                            Sin evaluar
                        @endif
                    </span>
                </div>
            </div>
            <div class="card mb-3 shadow-sm">
                <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary w-100">Nueva Evaluación</a>
            </div>
            @if(auth()->user()->rol == 'admin')
                <div class="card mb-3 shadow-sm">
                    <a href="{{ route('ejercicios.index') }}" class="btn btn-info w-100 text-white">Ejercicios</a>
                </div>
            @endif
        </div>

        <!-- Columna principal -- GRAFICAS -- -->
        <div class="col-lg-9 col-md-8">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <canvas id="bloqueMax" style="width:100%;"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <canvas id="dominadas" style="width:100%;"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <canvas id="flexiones" style="width:100%;"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <canvas id="regleta" style="width:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        @if(!$planEntrenamiento || !$planEntrenamiento->iniciado)
            <div class="alert alert-info text-center shadow-sm">
                @if(auth()->user()->planes_completados >= 2)
                    Has completado dos planes de entrenamiento. Es hora de realizar una nueva evaluación.
                    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary ms-2">Realizar Evaluación</a>
                @elseif($evaluaciones->count() > 0)
                    <form method="POST" action="{{ route('planEntrenamiento.generar') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Comienza a Entrenar</button>
                    </form>
                @else
                    Debes realizar una evaluación primero para comenzar un entrenamiento.
                @endif
            </div>
        @endif

        @if($planEntrenamiento && $planEntrenamiento->iniciado)
            <div class="card shadow rounded-4 mb-4 w-100">
                <div class="card-header bg-gradient bg-primary text-white d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1 d-flex justify-content-start">
                        @if($dia > 1)
                            <a href="{{ route('dashboard', ['dia' => (int)$dia - 1]) }}" class="btn btn-sm btn-outline-light">&larr;</a>
                        @endif
                    </div>
                    <div class="flex-grow-2 text-center">
                        <h5 class="mb-0">
                            Entrenamiento - Día {{ $dia }} / 12
                            <span class="badge bg-light text-dark ms-2">{{ $tipoEntrenamiento }}</span>
                        </h5>
                    </div>
                    <div class="flex-grow-1 d-flex justify-content-end">
                        @if($dia < 12)
                            <a href="{{ route('dashboard', ['dia' => (int)$dia + 1]) }}" class="btn btn-sm btn-outline-light">&rarr;</a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($nivel)
                        {{-- Calentamiento --}}
                        <h4 class="mb-3"><i class="fas fa-fire text-warning me-2"></i>Calentamiento</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover table-striped align-middle shadow-sm">
                                <thead class="table-warning">
                                    <tr>
                                        <th style="text-align:left;">Ejercicio</th>
                                        <th>Series</th>
                                        <th>Repeticiones</th>
                                        <th>Duración</th>
                                        <th>Completado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calentamientos as $calentamiento)
                                        <tr class="{{ $calentamiento->completado ? 'table-success' : '' }}">
                                            <td style="text-align:left; cursor:pointer;" onclick="verDescripcion('{{ $calentamiento->ejercicio->nombre }}', '{{ $calentamiento->ejercicio->descripcion }}')">
                                                <i class="fas fa-fire text-warning me-2"></i> {{ $calentamiento->ejercicio->nombre }}
                                            </td>
                                            <td>
                                                @if($calentamiento->ejercicio->series)
                                                    <span class="badge bg-primary">{{ $calentamiento->ejercicio->series }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($calentamiento->ejercicio->repeticiones)
                                                    <span class="badge bg-primary">{{ $calentamiento->ejercicio->repeticiones }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($calentamiento->ejercicio->duracion)
                                                    <span class="badge bg-info">{{ $calentamiento->ejercicio->id < 4 ? $calentamiento->ejercicio->duracion . ' Min.' : $calentamiento->ejercicio->duracion . ' Seg.' }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <input type="checkbox" class="form-check-input checkbox-dia m-0" style="transform: scale(1.2); vertical-align: middle;" onchange="completadoEjercicio(this, {{ $calentamiento->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $calentamiento->completado ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Entrenamiento --}}
                        <h4 class="mb-3"><i class="fas fa-dumbbell text-primary me-2"></i>Entrenamiento</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover table-striped align-middle shadow-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="text-align:left;">Ejercicio</th>
                                        <th>Series</th>
                                        <th>Repeticiones</th>
                                        <th>Duración</th>
                                        <th>Completado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ejercicios as $ejercicio)
                                        <tr class="{{ $ejercicio->completado ? 'table-success' : '' }}">
                                            <td style="text-align:left; cursor:pointer;" onclick="verDescripcion('{{ $ejercicio->ejercicio->nombre }}', '{{ $ejercicio->ejercicio->descripcion }}')">
                                                <i class="fas fa-dumbbell text-primary me-2"></i> {{ $ejercicio->ejercicio->nombre }}
                                            </td>
                                            <td>
                                                @if($ejercicio->ejercicio->series)
                                                    <span class="badge bg-primary">{{ $ejercicio->ejercicio->series }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ejercicio->ejercicio->repeticiones)
                                                    <span class="badge bg-primary">{{ $ejercicio->ejercicio->repeticiones }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ejercicio->ejercicio->duracion)
                                                    <span class="badge bg-info">{{ $ejercicio->ejercicio->id <= 4 ? $ejercicio->ejercicio->duracion . ' Min.' : $ejercicio->ejercicio->duracion . ' Seg.' }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input checkbox-dia m-0" style="transform: scale(1.2);" onchange="completadoEjercicio(this, {{ $calentamiento->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $calentamiento->completado ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Estiramientos --}}
                        <h4 class="mb-3"><i class="fas fa-child text-success me-2"></i>Estiramientos</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover table-striped align-middle shadow-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th style="text-align:left;">Ejercicio</th>
                                        <th>Series</th>
                                        <th>Repeticiones</th>
                                        <th>Duración</th>
                                        <th>Completado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estiramientos as $estiramiento)
                                        <tr class="{{ $estiramiento->completado ? 'table-success' : '' }}">
                                            <td style="text-align:left; cursor:pointer;" onclick="verDescripcion('{{ $estiramiento->ejercicio->nombre }}', '{{ $estiramiento->ejercicio->descripcion }}')">
                                                <i class="fas fa-child text-success me-2"></i> {{ $estiramiento->ejercicio->nombre }}
                                            </td>
                                            <td>
                                                @if($estiramiento->ejercicio->series)
                                                    <span class="badge bg-primary">{{ $estiramiento->ejercicio->series }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($estiramiento->ejercicio->repeticiones)
                                                    <span class="badge bg-primary">{{ $estiramiento->ejercicio->repeticiones }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($estiramiento->ejercicio->duracion)
                                                    <span class="badge bg-info">{{ $estiramiento->ejercicio->duracion }} Seg.</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input checkbox-dia m-0" style="transform: scale(1.2);" onchange="completadoEjercicio(this, {{ $calentamiento->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $calentamiento->completado ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="completarDiaContenedor" style="display: none; text-align: center; margin-top: 30px;">
                            <button class="btn btn-success btn-lg shadow rounded-pill px-5 py-2" style="font-size: 1.2rem;" onclick="completarDia()">
                                <i class="fas fa-check-circle me-2"></i>Completar Día
                            </button>
                        </div>
                    @else
                        <p class="text-center">No has iniciado un plan de entrenamiento aún.</p>
                    @endif
                </div>
                <div class="progress" style="height: 30px; margin-bottom: 20px; border-radius: 20px;">
                    <div id="progressBar" class="progress-bar bg-gradient bg-success" role="progressbar" style="width: {{ $progreso }}%; font-size: 1.1rem; border-radius: 20px;" aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100">
                        Día {{ count($planEntrenamiento->dias_completados ?? []) }} de 12
                    </div>
                </div>
            </div>
        @endif        
    </div>

    <!-- Footer -->
    <hr style="border: 1px solid rgb(11, 75, 112); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
</div>

<!-- Modal para mostrar la descripción del ejercicio -->
<div class="modal fade" id="modalEjercicios" tabindex="-1" aria-labelledby="etiquetaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(40, 113, 173)">
                <h5 class="modal-title" id="etiquetaModal"><p id="nombreEjercicio"></p></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="descripcionEjercicio">Cargando...</p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: rgb(40, 113, 173)">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@include('components.cookies')
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .table th, .table td {
            vertical-align: middle !important;
            text-align: center;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .badge {
            font-size: 1rem;
        }
        .btn-success {
            box-shadow: 0 4px 14px rgba(67, 240, 78, 0.15);
        }
        .progress-bar {
            font-weight: bold;
            letter-spacing: 1px;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function verDescripcion(nombre, description) {
            document.getElementById('nombreEjercicio').innerText = nombre;
            document.getElementById('descripcionEjercicio').innerText = description;
            var modalEjercicios = new bootstrap.Modal(document.getElementById('modalEjercicios'));
            modalEjercicios.show();
        }

        async function completadoEjercicio(checkbox, ejercicioId, dia, planId) {
            const completado = checkbox.checked;
            const row = checkbox.closest('tr');
            row.classList.toggle('table-success', completado);

            try {
                const response = await fetch(`/plan-ejercicios/actualizar-estado/${ejercicioId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ completado, dia, plan_id: planId })
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Error al actualizar');
                }
            } catch (error) {
                alert('Hubo un problema al actualizar el estado.');
                checkbox.checked = !completado;
                row.classList.toggle('table-success', !completado);
            }

            verificarCheckboxes();
        }

        function verificarCheckboxes() {
            const checkboxes = document.querySelectorAll('.checkbox-dia');
            const todosMarcados = Array.from(checkboxes).every(checkbox => checkbox.checked);
            const completarDiaContenedor = document.getElementById('completarDiaContenedor');
            if (todosMarcados && checkboxes.length > 0) {
                completarDiaContenedor.style.display = 'block';
            } else {
                completarDiaContenedor.style.display = 'none';
            }
        }

        async function completarDia() {
            const dia = {{ $dia }};
            const progressBar = document.getElementById('progressBar');
            const nuevoProgreso = (dia / 12) * 100;
            progressBar.style.width = `${nuevoProgreso}%`;
            progressBar.setAttribute('aria-valuenow', dia);
            progressBar.textContent = `Día ${dia} de 12`;

            try {
                const response = await fetch('/planEntrenamiento/completar-dia', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ dia })
                });

                const data = await response.json();
                if (!response.ok) throw new Error();

                if (data.message.includes('El día ya está completado')) {
                    alert('El día ya estaba completado anteriormente.');
                    return;
                }
                alert(data.message);

                if (data.message.includes('nueva evaluación')) {
                    window.location.href = "{{ route('evaluaciones.create') }}";
                } else if (data.message.includes('nuevo plan')) {
                    window.location.reload();
                }
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } catch (error) {
                alert('Hubo un problema al completar el día. Por favor, inténtalo de nuevo.');
                progressBar.style.width = `${(dia - 1) / 12 * 100}%`;
                progressBar.setAttribute('aria-valuenow', dia - 1);
                progressBar.textContent = `Día ${dia - 1} de 12`;
            }
        }

        function crearGrafica(id, labels, data, ejeY, label, tipo, color) {
            const ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    // Mostrar el grado correspondiente en lugar del índice
                                    const value = context.raw; // Valor del índice
                                    return `${ejeY[value]}`; // Mostrar el grado
                                }
                            }
                        },
                        datalabels: {
                            formatter: function (value, context) {
                                return ejeY[value]; // Mostrar el nivel correspondiente
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value, index, values) {
                                    return ejeY[value]; // Mostrar el nivel correspondiente en el eje Y
                                }
                            },
                            min: 0, // Índice mínimo
                            max: ejeY.length - 1, // Índice máximo
                            title: {
                                display: true,
                            }
                        },
                        x: {
                            title: {
                                display: true,
                            }
                        }
                    }
                }
            });
        }

        function crearGraficaEjeYInvertido(id, labels, data, ejeY, label, tipo, color) {
            const ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    // Mostrar el grado correspondiente en lugar del índice
                                    const value = context.raw; // Valor del índice
                                    return `${ejeY[value]}`; // Mostrar el grado
                                }
                            }
                        },
                        datalabels: {
                            formatter: function (value, context) {
                                return ejeY[value]; // Mostrar el nivel correspondiente
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value, index, values) {
                                    return ejeY[value]; // Mostrar el nivel correspondiente en el eje Y
                                }
                            },
                            min: 0, // Índice mínimo
                            max: ejeY.length - 1, // Índice máximo
                            title: {
                                display: true,
                            }
                        },
                        x: {
                            title: {
                                display: true,
                            }
                        }
                    }
                }
            });
        }
    

        // Inicializar los gráficos al cargar la página
        // Aseguramos de que el DOM esté completamente cargado antes de ejecutar el script
        document.addEventListener('DOMContentLoaded', function () {
            const configuracionesGraficos = [
                {
                    id: 'bloqueMax',
                    datos: @json($bloques),
                    fechas: @json($fechasEvaluaciones),
                    ejeY: ['3', '4', '5a', '5b', '6a', '6b', '6c', '7a', '7b', '7c', '8a'],
                    etiqueta: 'Grado en Bloque',
                    invertido: false,
                    tipo: 'bar',
                    color: 'rgba(241, 118, 29, 0.678)'
                },
                {
                    id: 'dominadas',
                    datos: @json($dominadas),
                    fechas: @json($fechasEvaluaciones),
                    ejeY: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50'],
                    etiqueta: 'Dominadas al Fallo',
                    invertido: false,
                    tipo: 'line',
                    color: 'rgba(67, 240, 78, 0.671)'
                },
                {
                    id: 'flexiones',
                    datos: @json($flexiones),
                    fechas: @json($fechasEvaluaciones),
                    ejeY: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50'],
                    etiqueta: 'Flexiones al Fallo',
                    invertido: false,
                    tipo: 'bar',
                    color: 'rgba(51, 125, 148)'
                },
                {
                    id: 'regleta',
                    datos: @json($minimaRegleta),
                    fechas: @json($fechasEvaluaciones),
                    ejeY: ['40', '30', '20', '18', '16', '14', '12', '10', '8', '6', '4'],
                    etiqueta: 'Regleta Minima (10Seg)',                    
                    invertido: true,
                    tipo: 'line',
                    color: 'rgba(240, 4, 35, 0.678)'
                }
            ];

            configuracionesGraficos.forEach(configuracion => {
                let datosGraficos = configuracion.datos;
                if (configuracion.id === 'regleta') {
                    datosGraficos = configuracion.datos.map(valor => configuracion.ejeY.indexOf(valor.toString()));
                }
                if (configuracion.invertido) {
                    crearGraficaEjeYInvertido(
                        configuracion.id,
                        configuracion.fechas,
                        datosGraficos, // <--- ¡Aquí el cambio!
                        configuracion.ejeY,
                        configuracion.etiqueta,
                        configuracion.tipo,
                        configuracion.color
                    );
                } else {
                    crearGrafica(
                        configuracion.id,
                        configuracion.fechas,
                        datosGraficos,
                        configuracion.ejeY,
                        configuracion.etiqueta,
                        configuracion.tipo,
                        configuracion.color
                    );
                }
            });
        });
    </script>
@stop

