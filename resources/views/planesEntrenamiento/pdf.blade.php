<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Entrenamiento</title>
    <style>
        body 
        {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table 
        {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td 
        {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        th 
        {
            background-color: #f2f2f2;
        }
        h2 
        {
            margin-top: 30px;
        }
        .saltoPagina
        {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <h2 style="margin-top: 5px">Plan de Entrenamiento de {{ $user->name }} {{ $user->primer_apellido }} {{ $user->segundo_apellido }}</h2>
    <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($planEntrenamiento->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
    <p><strong>Nombre del Plan:</strong> {{ $planEntrenamiento->nombre }}</p>
    <p><strong>Nivel:</strong> {{ $planEntrenamiento->nivel }}</p>        
             
    @foreach($ejerciciosPorDia as $dia => $ejercicios)  
        @if(!$loop->first && $loop->index % 2 == 0)
            <div class="saltoPagina"></div>
        @endif      
        <h2>Día {{ $dia }} - {{ $tiposEntrenamiento[$dia] }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Ejercicio</th>
                    <th>Tipo</th>
                    <th>Series</th>
                    <th>Repeticiones</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ejercicios as $ejercicio)
                    <tr>
                        <td>{{ $ejercicio->ejercicio->nombre }}</td>
                        <td>{{ $ejercicio->ejercicio->tipo }}</td>
                        <td>{{ $ejercicio->ejercicio->series ?? '-' }}</td>
                        <td>{{ $ejercicio->ejercicio->repeticiones ?? '-' }}</td>
                        <td>
                            @if($ejercicio->ejercicio->duracion)
                                @if($ejercicio->ejercicio->id <= 4)
                                    {{ $ejercicio->ejercicio->duracion }} Min.
                                @else
                                    {{ $ejercicio->ejercicio->duracion }} Seg.
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach   
    
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_text(230, 800, "Página {PAGE_NUM} de {PAGE_COUNT} - AppEscalada", null, 10, array(0, 0, 0));
            $pdf->page_text(525, 800, date('d/m/Y'), null, 10, array(0, 0, 0) );
        }
    </script>
</body>
</html>