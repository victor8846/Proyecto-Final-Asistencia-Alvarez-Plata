@extends('layouts.adminlte')
@section('title', 'Registrar Asistencia Manual')

@section('content')
<div class="container">
    <h1>Registrar Asistencia Manual</h1>
    <form action="{{ route('asistencias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="alumno_id">Alumno</label>
            <select name="alumno_id" class="form-control" required>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->nombre }} {{ $alumno->apellido }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="materia_id">Materia</label>
            <select name="materia_id" class="form-control" required>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="curso_id">Curso</label>
            <select name="curso_id" class="form-control" required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="hora_ingreso">Hora de Ingreso</label>
            <input type="text" name="hora_ingreso" class="form-control" placeholder="Ej: 08:00" required>
        </div>

        <div class="mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Registrar</button>
        <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
