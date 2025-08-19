@extends('layouts.adminlte')

@section('title', 'Docentes')

@section('content')
<div class="container">
    <h1>Lista de Docentes</h1>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('docentes.index') }}" class="row g-3 mb-4">

    <div class="col-md-4">
        <select name="docente_id" class="form-control">
            <option value="">Seleccione un docente</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}" {{ request('docente_id') == $docente->id ? 'selected' : '' }}>
                    {{ $docente->nombre_completo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <select name="carrera" class="form-control">
            <option value="">-- Seleccionar carrera --</option>
            @foreach($carreras as $carrera)
                <option value="{{ $carrera->id }}" {{ request('carrera') == $carrera->id ? 'selected' : '' }}>
                    {{ $carrera->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Limpiar</a>
    </div>

</form>


    <a href="{{ route('docentes.create') }}" class="btn btn-primary mb-3">Nuevo Docente</a>

   {{-- Notificación con SweetAlert2 --}}
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
               text: "{{ session('success') }}", 
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        });
    </script>
@endif



    <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Carrera</th>
                <th>Materia</th>
                <th>CI</th>
                <th>UID NFC</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($docentes as $docente)
                <tr>
                    <td>{{ $docente->nombre }}</td>
                    <td>{{ $docente->apellido_paterno }}</td>
                    <td>{{ $docente->apellido_materno }}</td>
                    <td>{{ $docente->carrera->nombre ?? '-' }}</td>
                    <td>{{ $docente->materia->nombre ?? '-' }}</td>
                    <td>{{ $docente->ci }}</td>
                    <td>{{ $estudiante->uid_nfc ?? 'N/A' }}</td>
                    <td>{{ $docente->email }}</td>
                    <td>
                        <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('docentes.destroy', $docente) }}" method="POST" style="display:inline" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $docentes->appends(request()->query())->links() }}
    </div>
</div>
@endsection
