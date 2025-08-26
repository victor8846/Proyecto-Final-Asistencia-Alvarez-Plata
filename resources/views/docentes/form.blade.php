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
    <div class="input-group">
        <input type="text"
               name="uid_nfc"
               id="uid_nfc"
               class="form-control"
               value="{{ old('uid_nfc', $docente->uid_nfc ?? '') }}"
               readonly>
        <input type="hidden" id="lectura_id">
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" id="btn-obtener-uid">
                Registrar UID NFC
            </button>
        </div>
    </div>
    <small id="nfc-status" class="form-text text-muted">
        Pase la tarjeta por el lector y luego haga clic en "Registrar UID NFC".
    </small>
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

<!-- Modal NFC -->
<div class="modal fade" id="modalNFC" tabindex="-1" role="dialog" aria-labelledby="modalNFCLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4" id="modal-nfc-content">
            <h5 class="modal-title mb-3" id="modalNFCLabel">Registrar Tarjeta NFC</h5>
            <p class="mb-3" id="modalNFCMessage">Por favor, acerque la tarjeta al lector...</p>
            <div class="spinner-border text-primary mb-3" role="status" id="modalNFCSpinner">
                <span class="sr-only">Leyendo...</span>
            </div>
            <div id="modalNFCSuccess" style="display: none;">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p class="text-success">Tarjeta detectada</p>
            </div>
            <small class="text-muted" id="modalNFCFooter">Esperando lectura...</small>
        </div>
    </div>
</div>

<script>
    // Cargar materias dinámicamente
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
                            option.textContent = materia.nombre;
                            materiaSelect.appendChild(option);
                        });
                    });
            } else {
                materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
            }
        });
    });

    // Capitalizar y permitir solo letras
    document.querySelectorAll('.capitalize').forEach(input => {
        input.addEventListener('input', function () {
            if (this.classList.contains('letras')) {
                this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚÑáéíóúñ\s]/g, '');
            }
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });
    });

    // Sistema de lectura NFC
    (function () {
        const API_KEY = 'INCOS2025';
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
                const res = await fetch('/api/nfc-lectura/ultimo', { cache: 'no-store' });
                const data = await res.json();

                if (data && data.id && data.uid_nfc) {
                    if (data.id !== lastSeenId) {
                        uidInput.value = data.uid_nfc;
                        lecturaIdInput.value = data.id;
                        lastSeenId = data.id;
                        setStatus('Tarjeta detectada: ' + data.uid_nfc + ' (sin confirmar)');
                    }
                } else {
                    if (!isConfirming && !lecturaIdInput.value) {
                        setStatus('Esperando tarjeta...');
                    }
                }
            } catch (e) {
                console.error('Error al consultar último UID:', e);
                setStatus('Error al consultar el lector. Intente nuevamente.');
            }
        }

        function startPolling() {
            if (poller) return;
            setStatus('Esperando tarjeta...');
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
                setStatus('No hay UID para registrar. Acerque la tarjeta al lector.');
                fetchUltimo();
                return;
            }

            if (isConfirming) return;
            isConfirming = true;
            btnRegistrar.disabled = true;
            setStatus('Confirmando UID...');

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
                    const msg = data && data.message ? data.message : 'Error al registrar UID';
                    setStatus(msg);
                    if (window.Swal) Swal.fire('Error', msg, 'error');
                } else {
                    setStatus('UID confirmado y listo en el formulario.');
                    lecturaIdInput.value = '';
                    lastSeenId = null;

                    if (window.Swal) Swal.fire('¡Listo!', data.message || 'UID confirmado', 'success');
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
