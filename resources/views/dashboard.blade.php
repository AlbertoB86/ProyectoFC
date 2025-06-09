@extends('adminlte::page')

@section('title', 'APP Escalada - Inicio')

@section('content_header')  
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">            
            <h4>{{ auth()->user()->name }} {{ auth()->user()->primer_apellido }} {{ auth()->user()->segundo_apellido }}</h4>
                
            <div>
                {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row" style="display: flex; justify-content:space-between;">   
            <!-- Primera columna -->
            <div class="col-lg-3 col-md-3">
                <!-- Tarjeta de Nivel -->     
                <div class="info-box" style="background-color: rgba(241, 118, 29, 0.678)">
                    <span class="info-box-icon"><i class="fas fa-mountain"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Nivel Actual</span>
                        <span class="info-box-number">
                            @if(auth()->user()->ultimaEvaluacion)
                                {{ auth()->user()->ultimaEvaluacion->nivel }}
                            @else
                                Sin evaluar
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Última Evaluación -->
                <div class="info-box" style="background-color:rgba(67, 240, 78, 0.671)">
                    <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Última Evaluación</span>
                        <span class="info-box-number">
                            @if(auth()->user()->ultimaEvaluacion)
                                {{ \Carbon\Carbon::parse(auth()->user()->ultimaEvaluacion->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                            @else
                                Sin evaluar
                            @endif
                        </span>
                    </div>
                </div>

                <div class="card mb-3">
                    <a href="{{ route('evaluaciones.create') }}" class="btn" style="background-color: rgb(51, 125, 148); color:blanchedalmond">Nueva Evaluación</a>
                </div>
                <!-- Si el usuario es ADMIN podremos ver el boton para ir al listado de Ejercicios -->
                @if(auth()->user()->rol == 'admin')
                    <div class="card mb-3">
                        <a href="{{ route('ejercicios.index') }}" class="btn" style="background-color: rgb(51, 125, 148); color:blanchedalmond">Ejercicios</a>
                    </div>
                @endif        
            </div>
            
            <!-- Segunda columna -->
            <div class="col-lg-9 col-md-6 " style="display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-top: 20px;"> 
                <div class="col-lg-5 col-md-6" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-top: -10px">
                    <canvas id="bloqueMax" style="width: 400px"></canvas>
                </div>

                <div class="col-lg-5 col-md-6" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-top: -10px">
                    <canvas id="dominadas" style="width: 400px"></canvas>
                </div>

                <div class="col-lg-5 col-md-6" style="height: 150px; display: flex; justify-content: center; align-items: center;">
                    <canvas id="flexiones" style="width: 400px"></canvas>
                </div>
                
                <div class="col-lg-5 col-md-6" style="height: 150px; display: flex; justify-content: center; align-items: center;">
                    <canvas id="regleta" style="width: 400px"></canvas>
                </div>
            </div>
        </div>

        <hr style="border: 1px solid rgb(11, 75, 112); width: 100%; margin-top: 50px; margin-bottom: 50px;">  

        <div style="display: flex ; justify-content: center;">        
            @if(!$planEntrenamiento || !$planEntrenamiento->iniciado)
                @if(auth()->user()->planes_completados >= 2)
                    <div class="alert alert-info">
                        Has completado dos planes de entrenamiento. Es hora de realizar una nueva evaluación.
                        <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">Realizar Evaluación</a>
                    </div>
                @elseif($evaluaciones->count() > 0)
                    <form method="POST" action="{{ route('planEntrenamiento.generar') }}" >
                        @csrf
                        <button class="btn btn-success" style="justify-content: center; border: 1px solid black;">Comienza a Entrenar</button>
                    </form>
                @else
                    <div class="alert alert-warning">Debes realizar una evaluación primero para comenzar un entrenamiento.</div>
                @endif
            @endif
        </div> 

        <div class="col-12">
            @if($planEntrenamiento && $planEntrenamiento->iniciado)
                <div class="card mt-4" style="width: 100%; border: 1px solid black; border-radius: 10px; padding: 20px;">
                    <div class="card-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <!-- Botón de navegación izquierda -->
                            @if($dia > 1)
                                <a href="{{ route('dashboard', ['dia' => (int)$dia - 1]) }}" class="btn btn-sm btn-outline-secondary mb-2 mb-md-0">&larr;</a>
                            @else
                                <span class="d-none d-md-block"></span> <!-- Espaciador para mantener alineación -->
                            @endif
                    
                            <!-- Título del entrenamiento -->
                            <h5 class="text-center mb-2 mb-md-0">Entrenamiento - Día {{ $dia }} / 12 -- ({{ $tipoEntrenamiento }})</h5>
                    
                            <!-- Botón de navegación derecha -->
                            @if($dia < 12)
                                <a href="{{ route('dashboard', ['dia' => (int)$dia + 1]) }}" class="btn btn-sm btn-outline-secondary mb-2 mb-md-0">&rarr;</a>
                            @else
                                <span class="d-none d-md-block"></span> <!-- Espaciador para mantener alineación -->
                            @endif
                        </div>
                    </div>  
                    
                    <div class="card-body">
                        @if($nivel)
                            <h4>🔄 Calentamiento</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="align-items: center; width: 100%; margin-bottom: 20px; text-align: center; vertical-align: middle;"> 
                                    <thead>
                                        <tr>
                                            <th style="text-align:left; vertical-align: middle;">Ejercicio</th>
                                            <th>Series</th>
                                            <th>Repeticiones</th>
                                            <th>Duración</th>
                                            <th>Completado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($calentamientos as $calentamiento)
                                            <tr style="background-color: {{ $calentamiento->completado ? 'lightgreen' : '' }}">
                                                <td onclick="verDescripcion('{{ $calentamiento->ejercicio->nombre }} ', ' {{ $calentamiento->ejercicio->descripcion }}')" style="text-align:left; vertical-align: middle;">{{ $calentamiento->ejercicio->nombre }}</td>
                                                <td>{{ $calentamiento->ejercicio->series ?? '-' }}</td>
                                                <td>{{ $calentamiento->ejercicio->repeticiones ?? '-' }}</td>
                                                <td>
                                                    @if($calentamiento->ejercicio->duracion)
                                                        {{ $calentamiento->ejercicio->id < 4 ? $calentamiento->ejercicio->duracion . ' Min.' : $calentamiento->ejercicio->duracion . ' Seg.' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" class="checkbox-dia"  onchange="completadoEjercicio(this, {{ $calentamiento->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $calentamiento->completado ? 'checked' : '' }}>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>    
                            <hr>
                            <h4>💪 Entrenamiento - {{ $tipoEntrenamiento }}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="align-items: center; width: 100%; margin-bottom: 20px; text-align: center; vertical-align: middle;"> 
                                    <thead>
                                        <tr>
                                            <th style="text-align:left; vertical-align: middle;">Ejercicio</th>
                                            <th>Series</th>
                                            <th>Repeticiones</th>
                                            <th>Duración</th>
                                            <th>Completado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ejercicios as $ejercicio)
                                            <tr style="background-color: {{ $ejercicio->completado ? 'lightgreen' : '' }}">
                                                <td onclick="verDescripcion('{{ $ejercicio->ejercicio->nombre }} ', ' {{ $ejercicio->ejercicio->descripcion }}')" style="text-align:left; vertical-align: middle;">{{ $ejercicio->ejercicio->nombre }}</td>
                                                <td>{{ $ejercicio->ejercicio->series ?? '-' }}</td>
                                                <td>{{ $ejercicio->ejercicio->repeticiones ?? '-' }}</td>
                                                <td>
                                                    @if($ejercicio->ejercicio->duracion)
                                                        {{ $ejercicio->ejercicio->id <= 4 ? $ejercicio->ejercicio->duracion . ' Min.' : $ejercicio->ejercicio->duracion . ' Seg.' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" class="checkbox-dia"  onchange="completadoEjercicio(this, {{ $ejercicio->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $ejercicio->completado ? 'checked' : '' }}>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>               
                            <hr>
                            <h4>🧘‍♂️ Estiramientos</h4>  
                            <div class="table-responsive">
                                <table class="table table-bordered" style="align-items: center; width: 100%; margin-bottom: 20px; text-align: center; vertical-align: middle;">                   
                                    <thead>
                                        <tr>
                                            <th style="text-align:left; vertical-align: middle; width: 35%">Ejercicio</th>
                                            <th>Series</th>
                                            <th>Repeticiones</th>
                                            <th>Duracion</th>
                                            <th>Completado</th>
                                        </tr>
                                    </thead>
                                    <tbody>                        
                                        @foreach ($estiramientos as $estiramiento)
                                            <tr style="background-color: {{ $estiramiento->completado ? 'lightgreen' : '' }}">
                                                <td onclick="verDescripcion('{{ $estiramiento->ejercicio->nombre }} ', ' {{ $estiramiento->ejercicio->descripcion }}')" style="text-align:left; vertical-align: middle;">{{ $estiramiento->ejercicio->nombre }}</td>                            
                                                @if($estiramiento->ejercicio->series != null)
                                                    <td>{{ $estiramiento->ejercicio->series }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                @if($estiramiento->ejercicio->repeticiones != null)
                                                    <td>{{ $estiramiento->ejercicio->repeticiones }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif                            
                                                <td>{{ $estiramiento->ejercicio->duracion }} Seg.</td>  
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" class="checkbox-dia"  onchange="completadoEjercicio(this, {{ $estiramiento->ejercicio->id }}, {{ $dia }}, {{ $planEntrenamiento->id }})" {{ $estiramiento->completado ? 'checked' : '' }}>
                                                        </label>
                                                    </div>                             
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                            </div> 
                            <div id="completarDiaContenedor" style="display: none; text-align: center; margin-top: 20px;">
                                <button class="btn btn-success" onclick="completarDia()">Completar Día</button>
                            </div>                
                        @else
                            <p style="align-items: center">No has iniciado un plan de entrenamiento aún.</p>
                        @endif
                    </div>
                    <div class="progress" style="height: 25px; margin-bottom: 20px;">
                        <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: {{ $progreso }}%;" aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="etiquetaModal">Descripcion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="nombreEjercicio"></p>
                    <p id="descripcionEjercicio">Cargando...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
        /* Ajustar el diseño de las tablas */
        .table {
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #f8f9fa;
        }

        /* Ajustar el diseño en pantallas pequeñas */
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
            // Establecer la descripción en el modal
            document.getElementById('nombreEjercicio').innerText = nombre; // Nombre del ejercicio
            document.getElementById('descripcionEjercicio').innerText = description;

            // Mostrar el modal
            var modalEjercicios = new bootstrap.Modal(document.getElementById('modalEjercicios'));
            modalEjercicios.show();
        }

        async function completadoEjercicio(checkbox, ejercicioId, dia, planId) {
            const completado = checkbox.checked; // Obtener el estado del checkbox (true o false)

            // Cambiar el fondo del <tr> según el estado del checkbox
            const row = checkbox.closest('tr');
            row.style.backgroundColor = completado ? 'lightgreen' : '';

            //cambiar el campo completado de la tabla plan_ejercicios
            try {
                const response = await fetch(`/plan-ejercicios/actualizar-estado/${ejercicioId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ completado, dia, plan_id: planId })
                });
 
                if (!response.ok){
                    const data = await response.json();
                    throw new Error(data.message || 'Error al actualizar');
                }

                console.log('Actualizado correctamente');
            } catch (error) {
                console.error('Error al actualizar el estado del ejercicio:', error);
                alert('Hubo un problema al actualizar el estado.');
                // Deshacer el cambio visual si falla
                checkbox.checked = !completado;
                row.style.backgroundColor = !completado ? 'lightgreen' : '';
            }            
            
            verificarCheckboxes(); 
        }

        function verificarCheckboxes() {
            // Solo selecciona los checkboxes del día actual
            const checkboxes = document.querySelectorAll('.checkbox-dia');
            const todosMarcados = Array.from(checkboxes).every(checkbox => checkbox.checked);

            // Mostrar el botón de "Completar Día"
            const completarDiaContenedor = document.getElementById('completarDiaContenedor');
            if (todosMarcados && checkboxes.length > 0) {
                completarDiaContenedor.style.display = 'block';
            } else {
                completarDiaContenedor.style.display = 'none';
            }
        }    

        async function completarDia() 
        {
            const dia = {{ $dia }}; // Obtener el día actual
            const progressBar = document.getElementById('progressBar'); // Obtener la barra de progreso
            const nuevoProgreso = (dia / 12) * 100; // Calcular el nuevo progreso
            progressBar.style.width = `${nuevoProgreso}%`; // Actualizar el ancho de la barra de progreso
            progressBar.setAttribute('aria-valuenow', dia); // Actualizar el valor actual
            progressBar.textContent = `Día ${dia} de 12`; // Actualizar el texto de la barra de progreso

            try{
            // Enviamos la solicitud al servidor para completar el día
            const response = await fetch('/planEntrenamiento/completar-dia', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ dia })
            });
            
            const data = await response.json();
            console.log('Respuesta del servidor:', data); // Imprimir la respuesta del servidor en la consola

            if(!response.ok){
                throw new Error();
            }

            // Si el día ya estaba completado, nos saldra un mensaje avisandonos
            if (data.message.includes('El día ya está completado')) {
                alert('El día ya estaba completado anteriormente.');
                return;
            }

            alert(data.message);

            if(data.message.includes('nueva evaluación')){
                // Redirigir a la página de evaluación
                window.location.href = "{{ route('evaluaciones.create') }}";
            }else if(data.message.includes('nuevo plan')){
                // Recargar la página para mostrar el nuevo plan
                window.location.reload();
            }
            if (data.redirect) {
                window.location.href = data.redirect; // Redirigir al día 1
            }
            }catch(error){
                console.error('Error al completar el día:', error);            
                alert('Hubo un problema al completar el día. Por favor, inténtalo de nuevo.');
                // Deshacer el cambio visual si falla
                progressBar.style.width = `${(dia - 1) / 12 * 100}%`;
                progressBar.setAttribute('aria-valuenow', dia - 1);
                progressBar.textContent = `Día ${dia - 1} de 12`;
            }
        }

        //---------------------------------- Gráficos-----------------------------------
        function crearGrafica(canvasId, fechas, datos, ejeY, etiqueta, tipo, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            new Chart(ctx, {
                type: tipo,
                data: {
                    labels: fechas, // Fechas de las evaluaciones
                    datasets: [{
                        label: etiqueta,
                        data: datos, // Índices de los niveles
                        borderWidth: 1,
                        backgroundColor: color,
                        borderColor: color,
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

        function crearGraficaEjeYInvertido(canvasId, fechas, datos, ejeY, etiqueta, tipo, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            const datosMapeados = datos.map(valor => ejeY.indexOf(valor.toString()));

            new Chart(ctx, {
                type: tipo,
                data: {
                    labels: fechas, // Fechas de las evaluaciones
                    datasets: [{
                        label: etiqueta,
                        data: datosMapeados,
                        borderWidth: 1,
                        backgroundColor: color,
                        borderColor: color,
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
                    ejeY: Array.from({ length: 51 }, (_, i) => i.toString()),
                    etiqueta: 'Dominadas al Fallo',
                    invertido: false,
                    tipo: 'line',
                    color: 'rgba(67, 240, 78, 0.671)'
                },
                {
                    id: 'flexiones',
                    datos: @json($flexiones),
                    fechas: @json($fechasEvaluaciones),
                    ejeY: Array.from({ length: 51 }, (_, i) => i.toString()),
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
                if (configuracion.invertido) {
                    crearGraficaEjeYInvertido(configuracion.id, configuracion.fechas, configuracion.datos, configuracion.ejeY, configuracion.etiqueta, configuracion.tipo, configuracion.color);
                } else {
                    crearGrafica(configuracion.id, configuracion.fechas, configuracion.datos, configuracion.ejeY, configuracion.etiqueta, configuracion.tipo, configuracion.color);
                }
            });
        });      
    </script>
@stop

