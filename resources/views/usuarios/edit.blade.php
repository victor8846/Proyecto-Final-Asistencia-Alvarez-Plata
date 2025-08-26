@extends('layouts.adminlte')

@section('title', 'Editar Usuario')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h1 class="mb-4">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" id="userForm" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <label for="name">Nombre <small class="text-muted">(Solo letras)</small></label>
                    <input type="text" name="name" id="name" 
                           class="form-control name-input" 
                           value="{{ old('name', $usuario->name) }}" 
                           required 
                           maxlength="50"
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="col-md-4">
                    <label for="apellido_paterno">Apellido Paterno <small class="text-muted">(Solo letras)</small></label>
                    <input type="text" name="apellido_paterno" 
                           id="apellido_paterno" 
                           class="form-control name-input"
                           value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" 
                           required 
                           maxlength="50"
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$">
                    <div class="invalid-feedback" id="apellidoPaternoError"></div>
                </div>
                <div class="col-md-4">
                    <label for="apellido_materno">Apellido Materno <small class="text-muted">(Solo letras)</small></label>
                    <input type="text" name="apellido_materno" 
                           id="apellido_materno" 
                           class="form-control name-input"
                           value="{{ old('apellido_materno', $usuario->apellido_materno) }}" 
                           required 
                           maxlength="50"
                           pattern="^[A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+( [A-Za-zÁáÉéÍíÓóÚúÜüÑñ]+)*$">
                    <div class="invalid-feedback" id="apellidoMaternoError"></div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="role_id">Rol</label>
                    <select name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $usuario->role_id == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="password">Nueva Contraseña (opcional)</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control"
                               pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
                               minlength="8">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="passwordError"></div>
                    <small id="passwordHelp" class="form-text text-muted">
                        <ul class="mb-0 pl-3">
                            <li id="minLength" class="requirement">Mínimo 8 caracteres</li>
                            <li id="hasLetter" class="requirement">Al menos una letra</li>
                            <li id="hasNumber" class="requirement">Al menos un número</li>
                            <li id="hasSymbol" class="requirement">Al menos un símbolo (@$!%*#?&)</li>
                        </ul>
                    </small>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="form-control">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="confirmPasswordError"></div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<style>
.requirement {
    color: #dc3545;
}
.requirement.valid {
    color: #28a745;
}
</style>
<script>
// Función para mostrar/ocultar contraseña
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = input.nextElementSibling.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

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

    // Validación de contraseña
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePassword(value) {
        const minLength = document.getElementById('minLength');
        const hasLetter = document.getElementById('hasLetter');
        const hasNumber = document.getElementById('hasNumber');
        const hasSymbol = document.getElementById('hasSymbol');
        
        // Validar longitud mínima
        if (value.length >= 8) {
            minLength.classList.add('valid');
        } else {
            minLength.classList.remove('valid');
        }
        
        // Validar letra
        if (/[A-Za-z]/.test(value)) {
            hasLetter.classList.add('valid');
        } else {
            hasLetter.classList.remove('valid');
        }
        
        // Validar número
        if (/\d/.test(value)) {
            hasNumber.classList.add('valid');
        } else {
            hasNumber.classList.remove('valid');
        }
        
        // Validar símbolo
        if (/[@$!%*#?&]/.test(value)) {
            hasSymbol.classList.add('valid');
        } else {
            hasSymbol.classList.remove('valid');
        }

        return value.length >= 8 && 
               /[A-Za-z]/.test(value) && 
               /\d/.test(value) && 
               /[@$!%*#?&]/.test(value);
    }

    if (password) {
        password.addEventListener('input', function() {
            validatePassword(this.value);
        });
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.classList.add('is-invalid');
                document.getElementById('confirmPasswordError').textContent = 'Las contraseñas no coinciden';
            } else {
                this.classList.remove('is-invalid');
                document.getElementById('confirmPasswordError').textContent = '';
            }
        });
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

    // Aplicar validación a cada campo de nombre
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

    // La función togglePassword ahora está definida globalmente

    // Validación del formulario antes de enviar
    document.getElementById('userForm').addEventListener('submit', function(e) {
        let hasError = false;
        let errorMessages = [];

        // Validar nombres
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

        // Validar contraseña si se ha ingresado
        if (password.value) {
            if (!validatePassword(password.value)) {
                hasError = true;
                errorMessages.push('La contraseña no cumple con los requisitos mínimos');
            }
            if (password.value !== confirmPassword.value) {
                hasError = true;
                errorMessages.push('Las contraseñas no coinciden');
            }
        }

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
