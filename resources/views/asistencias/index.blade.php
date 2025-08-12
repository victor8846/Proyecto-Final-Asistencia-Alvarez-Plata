@extends('layouts.adminlte')
@section('title', 'Control de Asistencias')

@section('content')
<div class="container">
    <h1>Asistencias del Día</h1>
    <a href="{{ route('asistencias.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Asistencia Manual
    </a>

    <form method="GET" action="{{ route('asistencias.index') }}" class="mb-4 row">
        <div class="col-md-4">
            <select name="curso_id" class="form-control">
                <option value="">-- Filtrar por curso --</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="materia_id" class="form-control">
                <option value="">-- Filtrar por materia --</option>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        <script>
            Swal.fire('Éxito', '{{ session('success') }}', 'success');
        </script>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Materia</th>
                <th>Hora Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $asistencia)
                <tr>
                    <td>{{ $asistencia->alumno->nombre }} {{ $asistencia->alumno->apellido }}</td>
                    <td>{{ $asistencia->curso->nombre }}</td>
                    <td>{{ $asistencia->materia->nombre }}</td>
                    <td>{{ $asistencia->hora_ingreso }}</td>
                    <td>
                        <a href="{{ route('asistencias.show', $asistencia->id) }}" class="btn btn-sm btn-info">Ver</a>
                        {{-- Aquí puedes agregar editar o eliminar si lo deseas --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay asistencias registradas hoy.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
