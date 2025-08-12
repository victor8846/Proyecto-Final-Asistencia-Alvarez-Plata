<!DOCTYPE html>
<html>
<head>
    <title>Horario PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Horarios por Carrera y Curso</h2>

    @php
        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    @endphp

    @foreach ($horarios as $grupo => $items)
        <h3>{{ $grupo }}</h3>
        @php
            // Ordenar los items por el orden de los días
            $itemsOrdenados = collect($items)->sortBy(function($item) use ($ordenDias) {
                return array_search($item->dia, $ordenDias);
            });
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Paralelo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemsOrdenados as $item)
                    <tr>
                        <td>{{ $item->dia }}</td>
                        <td>{{ $item->hora_inicio }}</td>
                        <td>{{ $item->hora_fin }}</td>
                        <td>{{ $item->materia->nombre }}</td>
                        <td>{{ $item->docente->nombre_completo }}</td>
                        <td>{{ $item->paralelo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
