<div class="form-group">
    <label>Carrera</label>
    <select name="carrera_id" class="form-control" required>
        <option value="">Seleccione una carrera</option>
        @foreach($carreras as $carrera)
            <option value="{{ $carrera->id }}" {{ (old('carrera_id', $horario->carrera_id ?? '') == $carrera->id) ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
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
    <label>Asignación Docente (Materia - Docente)</label>
    <select name="asignacion_docente_id" class="form-control" required>
        <option value="">Seleccione</option>
        @foreach($asignaciones as $asig)
            <option value="{{ $asig->id }}" {{ (old('asignacion_docente_id', $horario->asignacion_docente_id ?? '') == $asig->id) ? 'selected' : '' }}>
                {{ $asig->materia->nombre }} - {{ $asig->docente->nombre_completo }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Aula</label>
    <select name="aula_id" class="form-control" required>
        <option value="">Seleccione un aula</option>
        @foreach($aulas as $aula)
            <option value="{{ $aula->id }}" {{ (old('aula_id', $horario->aula_id ?? '') == $aula->id) ? 'selected' : '' }}>
                {{ $aula->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Día</label>
    <select name="dia" class="form-control" required>
        @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'] as $dia)
            <option value="{{ $dia }}" {{ (old('dia', $horario->dia ?? '') == $dia) ? 'selected' : '' }}>{{ $dia }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Hora Inicio</label>
    <input type="time" name="hora_inicio" class="form-control" value="{{ old('hora_inicio', $horario->hora_inicio ?? '') }}" required>
</div>

<div class="form-group">
    <label>Hora Fin</label>
    <input type="time" name="hora_fin" class="form-control" value="{{ old('hora_fin', $horario->hora_fin ?? '') }}" required>
</div>
