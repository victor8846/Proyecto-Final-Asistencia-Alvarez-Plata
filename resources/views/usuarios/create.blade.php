@extends('layouts.adminlte')

@section('title', 'Crear Usuario')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h1 class="mb-4">Crear Usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST" id="userForm">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control name-input" 
                           value="{{ old('name') }}" required
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$"
                           title="Solo se permiten letras y espacios simples entre palabras">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="col-md-4">
                    <label for="apellido_paterno">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control name-input"
                           value="{{ old('apellido_paterno') }}" required
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$"
                           title="Solo se permiten letras y espacios simples entre palabras">
                    <div class="invalid-feedback" id="apellidoPaternoError"></div>
                </div>
                <div class="col-md-4">
                    <label for="apellido_materno">Apellido Materno</label>
                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control name-input"
                           value="{{ old('apellido_materno') }}" required
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$"
                           title="Solo se permiten letras y espacios simples entre palabras">
                    <div class="invalid-feedback" id="apellidoMaternoError"></div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="role_id">Rol</label>
                    <select name="role_id" class="form-control" required>
                        <option value="">-- Seleccionar Rol --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                La contraseña será generada automáticamente y enviada al correo electrónico del usuario.
            </div>


            <button type="submit" class="btn btn-success mt-3">Guardar</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para capitalizar la primera letra de cada palabra
    function capitalizeWords(str) {
        return str.toLowerCase().replace(/(?:^|\s)\S/g, function(letter) {
            return letter.toUpperCase();
        });
    }

    // Función para validar el formato del nombre
    function validateNameFormat(value, fieldName) {
        if (!value) return { isValid: false, message: 'Este campo es requerido' };

        // Verifica si hay números
        if (/\d/.test(value)) {
            return {
                isValid: false,
                message: 'No se permiten números en el ' + fieldName
            };
        }

        // Verifica espacios múltiples o al inicio/final
        if (value.match(/^\s|\s$|\s\s+/)) {
            return {
                isValid: false,
                message: 'No se permiten espacios múltiples ni al inicio/final en el ' + fieldName
            };
        }

        // Verifica caracteres especiales
        if (!/^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ\s]*$/.test(value)) {
            return {
                isValid: false,
                message: 'Solo se permiten letras en el ' + fieldName
            };
        }

        // Verifica formato general
        if (!/^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$/.test(value)) {
            return {
                isValid: false,
                message: 'Formato inválido en el ' + fieldName + '. Use solo letras y espacios simples entre palabras'
            };
        }

        return { isValid: true, message: '' };
    }

    // Obtener todos los campos de nombre
    const nameInputs = document.querySelectorAll('.name-input');

    // Función para mostrar error con SweetAlert2
    function showError(message) {
        Swal.fire({
            title: '¡Error de Formato!',
            text: message,
            icon: 'warning',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        });
    }

    // Aplicar validación a cada campo
    nameInputs.forEach(input => {
        const fieldName = input.id === 'name' ? 'nombre' : 
                         input.id === 'apellido_paterno' ? 'apellido paterno' : 'apellido materno';

        input.addEventListener('input', function(e) {
            // Eliminar caracteres que no sean letras o espacios
            let value = this.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÜüÑñ\s]/g, '');
            
            // Eliminar espacios múltiples
            value = value.replace(/\s+/g, ' ').trim();
            
            // Capitalizar palabras
            value = capitalizeWords(value);
            
            // Actualizar el valor del campo
            this.value = value;
            
            // Validar el formato
            const validation = validateNameFormat(value, fieldName);
            if (!validation.isValid && value !== '') {
                this.classList.add('is-invalid');
                const errorDiv = document.getElementById(this.id + 'Error');
                if (errorDiv) {
                    errorDiv.textContent = validation.message;
                }
            } else {
                this.classList.remove('is-invalid');
                const errorDiv = document.getElementById(this.id + 'Error');
                if (errorDiv) {
                    errorDiv.textContent = '';
                }
            }
        });

        // Validación al perder el foco
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                const value = capitalizeWords(this.value.trim());
                this.value = value;
                
                const validation = validateNameFormat(value, fieldName);
                if (!validation.isValid) {
                    this.classList.add('is-invalid');
                    showError(validation.message);
                }
            }
        });
    });

    // Validación del formulario antes de enviar
    document.getElementById('userForm').addEventListener('submit', function(e) {
        let hasError = false;
        let errorMessages = [];

        nameInputs.forEach(input => {
            const fieldName = input.id === 'name' ? 'nombre' : 
                            input.id === 'apellido_paterno' ? 'apellido paterno' : 'apellido materno';
            
            const validation = validateNameFormat(input.value, fieldName);
            if (!validation.isValid) {
                input.classList.add('is-invalid');
                errorMessages.push(validation.message);
                hasError = true;
            }
        });

        if (hasError) {
            e.preventDefault();
            Swal.fire({
                title: '¡Error de Validación!',
                html: '<div style="text-align: left;">' + 
                      '<p>Por favor, corrija los siguientes errores:</p>' +
                      '<ul><li>' + errorMessages.join('</li><li>') + '</li></ul>' +
                      '</div>',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        }
    });
});
</script>
@endsection