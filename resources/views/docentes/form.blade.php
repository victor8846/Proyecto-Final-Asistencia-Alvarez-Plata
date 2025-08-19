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

<!-- UID NFC con botón -->
<div class="form-group">
    <label for="uid_nfc">UID NFC</label>
    <div class="input-group">
        <input type="text" name="uid_nfc" id="uid_nfc" class="form-control"
            value="{{ old('uid_nfc', $docente->uid_nfc ?? '') }}" readonly>
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" id="btn-obtener-uid">
                Registrar UID NFC
            </button>
        </div>
    </div>
    <small class="form-text text-muted">
        Presione el botón y pase la tarjeta por el lector.
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

    // Registrar UID NFC con animación
    document.getElementById('btn-obtener-uid').addEventListener('click', function () {
        $('#modalNFC').modal('show');

        document.getElementById('modalNFCSpinner').style.display = 'block';
        document.getElementById('modalNFCSuccess').style.display = 'none';
        document.getElementById('modalNFCMessage').textContent = 'Por favor, acerque la tarjeta al lector...';
        document.getElementById('modalNFCFooter').textContent = 'Esperando lectura...';

        let intentos = 0;
        let intervalo = setInterval(() => {
            fetch('/api/nfc-lectura/ultimo')
                .then(res => res.json())
                .then(data => {
                    if (data.uid_nfc) {
                        document.getElementById('uid_nfc').value = data.uid_nfc;

                        fetch('/api/nfc-lectura/confirmar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-API-KEY': 'INCOS2025'
                            },
                            body: JSON.stringify({ id: data.id })
                        });

                        document.getElementById('modalNFCSpinner').style.display = 'none';
                        document.getElementById('modalNFCSuccess').style.display = 'block';
                        document.getElementById('modalNFCMessage').textContent = '¡Tarjeta detectada!';
                        document.getElementById('modalNFCFooter').textContent = '';

                        clearInterval(intervalo);
                        setTimeout(() => { $('#modalNFC').modal('hide'); }, 1000);
                    }
                })
                .catch(console.error);

            intentos++;
            if (intentos > 10) {
                clearInterval(intervalo);
                $('#modalNFC').modal('hide');
                alert("No se detectó ninguna tarjeta.");
            }
        }, 2000);
    });
</script>
