{{-- resources/views/docentes/form.blade.php --}}
<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control letras capitalize" 
        value="{{ old('nombre', $docente->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
    <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control letras capitalize" 
        value="{{ old('apellido_paterno', $docente->apellido_paterno ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="apellido_materno" class="form-label">Apellido Materno</label>
    <input type="text" id="apellido_materno" name="apellido_materno" class="form-control letras capitalize" 
        value="{{ old('apellido_materno', $docente->apellido_materno ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="ci" class="form-label">CI</label>
    <input type="text" id="ci" name="ci" class="form-control" 
        value="{{ old('ci', $docente->ci ?? '') }}" required>
</div>
<!-- UID NFC -->
<div class="form-group">
    <label for="uid_nfc">UID NFC</label>
    <input type="text" name="uid_nfc" class="form-control"
        value="{{ old('uid_nfc', $docente->uid_nfc ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo</label>
    <input type="email" id="email" name="email" class="form-control" 
        value="{{ old('email', $docente->email ?? '') }}">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carreraSelect = document.getElementById('carrera_id');
        const materiaSelect = document.getElementById('materia_id');

        carreraSelect.addEventListener('change', function () {
            const carreraId = this.value;
            materiaSelect.innerHTML = '<option value="">Cargando...</option>';

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
            } else {
                materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
            }
        });
    });
</script>


{{-- Script para capitalizar y restringir a letras --}}
<script>
    document.querySelectorAll('.capitalize').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });
    });

    document.querySelectorAll('.letras').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚÑáéíóúñ\s]/g, '');
        });
    });
</script>
