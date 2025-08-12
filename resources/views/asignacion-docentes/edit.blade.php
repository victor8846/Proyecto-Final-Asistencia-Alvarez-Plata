@extends('layouts.adminlte')

@section('title', 'Editar Asignación')

@section('content_header')
    <h1>Editar Asignación de Docente</h1>
@stop

@section('content')
    <form action="{{ route('asignacion-docentes.update', $asignacion->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

       <div class="form-group">
    <label for="docente_id">Docente</label>
    <select name="docente_id" id="docente_id" class="form-control" required>
        <option value="">Seleccione un docente</option>
        @foreach ($docentes as $docente)
            <option value="{{ $docente->id }}" {{ old('docente_id', $asignacion->docente_id ?? '') == $docente->id ? 'selected' : '' }}>
                {{ $docente->nombre_completo }}
            </option>
        @endforeach
    </select>
</div>


       <div class="form-group">
    <label for="carrera_id">Carrera</label>
    <select name="carrera_id" id="carrera_id" class="form-control">
        <option value="">Seleccione una carrera</option>
        @foreach($carreras as $carrera)
            <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="materia_id">Materia</label>
    <select name="materia_id" id="materia_id" class="form-control">
        <option value="">Seleccione una materia</option>
        {{-- Las materias se cargarán dinámicamente --}}
    </select>
</div>

        <div class="form-group">
    <label for="curso_id">Curso</label>
    <select name="curso_id" class="form-control" required>
        <option value="">Seleccione un curso</option>
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}"
                {{ old('curso_id', $estudiante->curso_id ?? '') == $curso->id ? 'selected' : '' }}>
                {{ $curso->nombre }} {{ $curso->paralelo }}
            </option>
        @endforeach
    </select>
</div>
        <div class="form-group">
            <label for="dia">Día</label>
            <input type="text" name="dia" class="form-control" value="{{ $asignacion->dia }}" required>
        </div>

        <div class="form-group">
            <label for="hora_inicio">Hora de Inicio</label>
            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control"
    value="{{ old('hora_inicio', $asignacion->hora_inicio ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="hora_fin">Hora de Fin</label>
            <input type="time" name="hora_fin" id="hora_fin" class="form-control"
    value="{{ old('hora_fin', $asignacion->hora_fin ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('asignacion-docentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    <script>
    document.getElementById('carrera_id').addEventListener('change', function () {
        const carreraId = this.value;
        const materiaSelect = document.getElementById('materia_id');
        materiaSelect.innerHTML = '<option value="">Cargando...</option>';

        if (carreraId) {
            fetch(`/materias-por-carrera/${carreraId}`)
                .then(response => response.json())
                .then(data => {
                    materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
                    data.forEach(materia => {
                        materiaSelect.innerHTML += `<option value="${materia.id}">${materia.nombre}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error al cargar materias:', error);
                    materiaSelect.innerHTML = '<option value="">Error al cargar</option>';
                });
        } else {
            materiaSelect.innerHTML = '<option value="">Seleccione una carrera primero</option>';
        }
    });
</script>
@stop

