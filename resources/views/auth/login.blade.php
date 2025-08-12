<x-guest-layout>
    <!-- TÍTULO DEL SISTEMA -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-green-700">SISTEMA DE CONTROL</h1>
        <p class="text-gray-500 mt-2">Bienvenido al sistema</p>
    </div>

    <!-- MENSAJES DE SESIÓN -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- FORMULARIO LOGIN -->
    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

       <!-- Campo de usuario -->
<div class="relative mb-4">
    <!-- Input email -->
    <input type="email" id="email" name="email" placeholder="Correo electrónico"
           class="w-full pl-4 pr-12 py-4 rounded-lg border border-gray-300 bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
           value="{{ old('email') }}" required autofocus>
    <!-- Icono usuario -->
    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-500">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8.962 8.962 0 0112 15c2.485 0 4.735.994 6.379 2.618M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </span>
</div>

<!-- Campo de contraseña -->
<div class="relative mb-4">
    <!-- Input contraseña -->
    <input type="password" id="password" name="password" placeholder="Contraseña"
           class="w-full pl-4 pr-24 py-4 rounded-lg border border-gray-300 bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
           required>
    
    <!-- Botón mostrar/ocultar contraseña -->
    <button type="button" onclick="togglePasswordVisibility()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-600 focus:outline-none">
        <svg id="eye-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </button>
</div>


        <!-- RECORDARME Y OLVIDÉ CONTRASEÑA -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-blue-300 text-blue-600 shadow-sm focus:ring-blue-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200"
                   href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- BOTÓN LOGIN -->
        <div class="mt-10">
            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-800 text-white py-5 px-8 text-xl
                                         rounded-lg font-semibold hover:from-green-700 hover:to-green-900 
                                         focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 
                                         transform transition-all duration-200 hover:scale-[1.02] shadow-lg">
                Iniciar sesión
            </button>
        </div>
    </form>

    <!-- SCRIPT MOSTRAR/OCULTAR CONTRASEÑA -->
    <script>
    function togglePasswordVisibility() {
        const input = document.getElementById("password");
        const icon = document.getElementById("eye-icon");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
</x-guest-layout>
