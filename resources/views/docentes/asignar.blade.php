@extends('layouts.adminlte')

@section('title', 'Asignar Materia y Curso')

@section('content')
<div class="container">
    <h2>Asignar Materia y Curso a {{ $docente->nombre }} {{ $docente->apellido }}</h2>
    <form action="{{ route('docentes.asignar.store') }}" method="POST">
        @csrf
        <input type="hidden" name="docente_id" value="{{ $docente->id }}">

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
            <label for="dia">Día</label>
            <select name="dia" class="form-control" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Asignación</button>
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
