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
        <input type="text"
               name="uid_nfc"
               id="uid_nfc"
               class="form-control"
               value="{{ old('uid_nfc', $estudiante->uid_nfc ?? '') }}"
               readonly>
        <input type="hidden" id="lectura_id">
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" id="btn-obtener-uid">
                Registrar UID NFC
            </button>
        </div>
    </div>
    <small id="nfc-status" class="form-text text-muted">
        Pase la tarjeta por el lector y luego haga clic en “Registrar UID NFC”.
    </small>
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

<script>
  (function () {
    const API_KEY = 'INCOS2025'; // o usa tu .env (ver pasos más abajo)
    const uidInput = document.getElementById('uid_nfc');
    const lecturaIdInput = document.getElementById('lectura_id');
    const btnRegistrar = document.getElementById('btn-obtener-uid');
    const statusEl = document.getElementById('nfc-status');

    let poller = null;
    let lastSeenId = null;
    let isConfirming = false;

    function setStatus(msg) {
      if (statusEl) statusEl.textContent = msg;
    }

    async function fetchUltimo() {
      try {
        const res = await fetch('/api/nfc-lectura/ultimo', { 
          cache: 'no-store',
          headers: {
            'X-API-KEY': API_KEY
          }
        });
        const data = await res.json();

        // Esperamos un objeto tipo { id, uid_nfc } o { id: null, uid_nfc: null }
        if (data && data.id && data.uid_nfc) {
          // Evita relanzar la UI si es el mismo id
          if (data.id !== lastSeenId) {
            uidInput.value = data.uid_nfc;
            lecturaIdInput.value = data.id;
            lastSeenId = data.id;
            setStatus('Tarjeta detectada: ' + data.uid_nfc + ' (sin confirmar)');
            // Notificar al usuario
            if (window.Swal) {
              Swal.fire({
                title: '¡Tarjeta detectada!',
                text: 'Se ha detectado una tarjeta NFC. Haga clic en "Registrar UID NFC" para confirmar.',
                icon: 'info',
                confirmButtonText: 'OK'
              });
            }
          }
        } else {
          // No hay lectura pendiente
          if (!isConfirming && !lecturaIdInput.value) {
            setStatus('Esperando tarjeta…');
            // No limpiamos uidInput porque podría tener un UID ya asignado manualmente o confirmado
          }
        }
      } catch (e) {
        console.error('Error al consultar último UID:', e);
      }
    }

    function startPolling() {
      if (poller) return;
      setStatus('Esperando tarjeta…');
      poller = setInterval(fetchUltimo, 2000);
    }

    function stopPolling() {
      if (poller) {
        clearInterval(poller);
        poller = null;
      }
    }

    btnRegistrar.addEventListener('click', async () => {
      const id = lecturaIdInput.value;

      if (!id) {
        // No hay UID pendiente de confirmación
        setStatus('No hay UID para registrar. Acerque la tarjeta al lector.');
        // Forzamos una consulta inmediata por si acaba de pasar la tarjeta
        fetchUltimo();
        return;
      }

      if (isConfirming) return;
      isConfirming = true;
      btnRegistrar.disabled = true;
      setStatus('Confirmando UID…');

      try {
        const res = await fetch('/api/nfc-lectura/confirmar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-API-KEY': API_KEY
          },
          body: JSON.stringify({ id })
        });

        const data = await res.json();

        if (!res.ok) {
          // Muestra errores del backend
          const msg = data && data.message ? data.message : 'Error al registrar UID';
          setStatus(msg);
          // Opcional: SweetAlert si lo estás usando
          if (window.Swal) Swal.fire('Error', msg, 'error');
        } else {
          // Confirmación OK: dejamos el UID en el input del formulario y limpiamos el id interno
          setStatus('UID confirmado y listo en el formulario.');
          lecturaIdInput.value = '';
          lastSeenId = null;
          btnRegistrar.textContent = 'UID Confirmado';
          btnRegistrar.classList.remove('btn-primary');
          btnRegistrar.classList.add('btn-success');

          if (window.Swal) {
            Swal.fire({
              title: '¡UID Confirmado!',
              text: 'El UID de la tarjeta NFC ha sido confirmado. Puede continuar con el registro.',
              icon: 'success',
              confirmButtonText: 'Continuar'
            });
          }
        }
      } catch (e) {
        console.error('Error al confirmar UID:', e);
        setStatus('Error de red al confirmar UID');
        if (window.Swal) Swal.fire('Error', 'No se pudo confirmar el UID.', 'error');
      } finally {
        isConfirming = false;
        btnRegistrar.disabled = false;
      }
    });

    // Inicia el polling al cargar
    document.addEventListener('DOMContentLoaded', startPolling);
    // Limpia al salir
    window.addEventListener('beforeunload', stopPolling);
  })();
</script>

