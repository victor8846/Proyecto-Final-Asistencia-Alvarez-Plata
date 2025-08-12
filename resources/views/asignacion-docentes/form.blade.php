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


<!-- Select de Carrera -->
        <div class="form-group">
            <label for="carrera_id">Carrera</label>
            <select name="carrera_id" id="carrera_id" class="form-control" required>
                <option value="">Seleccione una carrera</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select de Materia (dinámico) -->
        <div class="form-group">
            <label for="materia_id">Materia</label>
            <select name="materia_id" id="materia_id" class="form-control" required>
                <option value="">Seleccione una materia</option>
            </select>
        </div>
<!-- Select de Curso (dinámico) -->
<div class="form-group">
    <label for="curso_id">Curso</label>
    <select name="curso_id" id="curso_id" class="form-control" required>
        <option value="">Seleccione un curso</option>
    </select>
</div>


<div class="form-group">
    <label for="dia">Día</label>
    <select name="dia" id="dia" class="form-control" required>
        <option value="">Seleccione un día</option>
        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
            <option value="{{ $dia }}" {{ old('dia', $asignacion->dia ?? '') == $dia ? 'selected' : '' }}>
                {{ $dia }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="hora_inicio">Hora de Inicio</label>
    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ old('hora_inicio', $asignacion->hora_inicio ?? '') }}" required>
</div>

<div class="form-group">
    <label for="hora_fin">Hora de Fin</label>
    <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ old('hora_fin', $asignacion->hora_fin ?? '') }}" required>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carreraSelect = document.getElementById('carrera_id');
        const materiaSelect = document.getElementById('materia_id');
        const cursoSelect = document.getElementById('curso_id');

        carreraSelect.addEventListener('change', function () {
            const carreraId = this.value;

            // Limpiar selects
            materiaSelect.innerHTML = '<option value="">Cargando...</option>';
            cursoSelect.innerHTML = '<option value="">Cargando...</option>';

            // Obtener materias
            if (carreraId) {
                fetch(`/materias/por-carrera/${carreraId}`)
                    .then(response => response.json())
                    .then(data => {
                        materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
                        data.forEach(materia => {
                            const option = document.createElement('option');
                            option.value = materia.id;
                            option.text = materia.nombre;
                            materiaSelect.appendChild(option);
                        });
                    });

                // Obtener cursos
                fetch(`/cursos/por-carrera/${carreraId}`)
                    .then(response => response.json())
                    .then(data => {
                        cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
                        data.forEach(curso => {
                            const option = document.createElement('option');
                            option.value = curso.id;
                            option.text = curso.nombre + ' ' + curso.paralelo;
                            cursoSelect.appendChild(option);
                        });
                    });
            } else {
                materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
                cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
            }
        });
    });
</script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
