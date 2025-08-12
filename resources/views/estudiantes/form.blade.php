@csrf

<div class="container">
    <div class="row">

        <!-- Columna 1 -->
        <div class="col-md-4">
            <!-- NOMBRE -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control capitalize letras"
                    value="{{ old('nombre', $estudiante->nombre ?? '') }}" required>
            </div>

            <!-- APELLIDO PATERNO -->
            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" class="form-control capitalize letras"
                    value="{{ old('apellido_paterno', $estudiante->apellido_paterno ?? '') }}" required>
            </div>

            <!-- APELLIDO MATERNO -->
            <div class="form-group">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" name="apellido_materno" class="form-control capitalize letras"
                    value="{{ old('apellido_materno', $estudiante->apellido_materno ?? '') }}" required>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-4">
            <!-- CI -->
            <div class="form-group">
                <label for="ci">CI</label>
                <input type="text" name="ci" class="form-control"
                    value="{{ old('ci', $estudiante->ci ?? '') }}" required>
            </div>

            <!-- UID NFC -->
            <div class="form-group">
                <label for="uid_nfc">UID NFC</label>
                <div class="input-group">
                    <input type="text" name="uid_nfc" id="uid_nfc" class="form-control" value="{{ old('uid_nfc', $estudiante->uid_nfc ?? '') }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary mt-2" id="btn-obtener-uid">Registrar UID NFC</button>
                    </div>
                </div>
                <small class="form-text text-muted">Presione el botón y pase la tarjeta por el lector.</small>
            </div>

            <!-- CORREO -->
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $estudiante->email ?? '') }}">
            </div>
        </div>

        <!-- Columna 3 -->
        <div class="col-md-4">
            <!-- CARRERA -->
            <div class="form-group">
                <label for="carrera_id">Carrera</label>
                <select name="carrera_id" id="carrera_id" class="form-control" required>
                    <option value="">Seleccione una carrera</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}"
                            {{ old('carrera_id', $estudiante->carrera_id ?? '') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- CURSO -->
            <div class="form-group">
                <label for="curso_id">Curso</label>
                <select name="curso_id" id="curso_id" class="form-control" required>
                    <option value="">Seleccione un curso</option>
                </select>
            </div>

            <!-- BOTÓN REGRESAR -->
            
                
            
        </div>
    </div>
</div>
<a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Regresar</a>
<!-- Cargar cursos dinámicamente -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carreraSelect = document.getElementById('carrera_id');
        const cursoSelect = document.getElementById('curso_id');

        carreraSelect.addEventListener('change', function () {
            const carreraId = this.value;
            cursoSelect.innerHTML = '<option value="">Cargando...</option>';

            if (carreraId) {
                fetch(`/cursos/por-carrera/${carreraId}`)
                    .then(response => response.json())
                    .then(data => {
                        cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
                        data.forEach(curso => {
                            const option = document.createElement('option');
                            option.value = curso.id;
                            option.textContent = `${curso.nombre} ${curso.paralelo}`;
                            cursoSelect.appendChild(option);
                        });
                    });
            } else {
                cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
            }
        });
    });
</script>

<!-- Capitalizar y permitir solo letras -->
<script>
    document.querySelectorAll('.capitalize').forEach(input => {
        input.addEventListener('input', function () {
            if (this.classList.contains('letras')) {
                this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚÑáéíóúñ\s]/g, '');
            }
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });
    });
</script>

<<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Registrar UID NFC</title>
</head>
<body>

<h2>Registrar UID NFC</h2>

<form id="formRegistrar" onsubmit="return false;">
  <label for="uid_input">UID NFC:</label>
  <input type="text" id="uid_input" name="uid_nfc" readonly />
  <input type="hidden" id="registro_id" />
  <button id="btnRegistrar">Registrar</button>
</form>

<script>
  // Consultar último UID no registrado cada 2 segundos
  setInterval(() => {
    fetch('/api/nfc-lectura/ultimo')
      .then(res => res.json())
      .then(data => {
        if (data.uid_nfc) {
          document.getElementById('uid_input').value = data.uid_nfc;
          document.getElementById('registro_id').value = data.id;
        }
      })
      .catch(console.error);
  }, 2000);

  // Al hacer clic en "Registrar"
  document.getElementById('btnRegistrar').addEventListener('click', () => {
    const id = document.getElementById('registro_id').value;
    if (!id) {
      alert('No hay UID para registrar');
      return;
    }

    fetch('/api/nfc-lectura/confirmar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': 'INCOS2025'
      },
      body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      document.getElementById('uid_input').value = '';
      document.getElementById('registro_id').value = '';
    })
    .catch(err => {
      alert('Error al registrar UID');
      console.error(err);
    });
  });
</script>

</body>
</html>

