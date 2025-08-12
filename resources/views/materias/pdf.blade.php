<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Materias</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Listado de Materias</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Carrera</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materias as $materia)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $materia->nombre }}</td>
                    <td>{{ $materia->carrera->nombre ?? 'Sin carrera' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
