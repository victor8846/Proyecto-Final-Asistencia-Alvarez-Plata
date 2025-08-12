<x-guest-layout>
    <!-- Título del sistema -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white ">SISTEMA DE CONTROL</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email con ícono de usuario -->
        <div class="mt-4">
            <div class="flex items-center bg-white border border-gray-300 rounded-full px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A8.962 8.962 0 0112 15c2.485 0 4.735.994 6.379 2.618M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input id="email" name="email" type="email" required autofocus autocomplete="username"
                       class="w-full outline-none text-sm text-gray-700 placeholder-gray-400"
                       placeholder="Correo electrónico" value="{{ old('email') }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-3 text-sm text-red-500" />
        </div>

        <!-- Contraseña con ícono de candado y ojo -->
        <div class="mt-4">
            <div class="flex items-center bg-white border border-gray-300 rounded-full px-3 py-2 relative">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 15v2m0 0a2 2 0 100-4v2zm6-2a6 6 0 00-12 0v4a2 2 0 002 2h8a2 2 0 002-2v-4z"/>
                </svg>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full outline-none text-sm text-gray-700 placeholder-gray-400"
                       placeholder="Contraseña">
                <!-- Ícono de ojo para mostrar contraseña -->
                <span class="absolute right-3 cursor-pointer" onclick="togglePasswordVisibility()">
                    <svg id="eye-icon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-3 text-sm text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <!-- Botón de login y link de olvido -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eye-icon");

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19
                    c-4.477 0-8.268-2.943-9.542-7a9.965 9.965 0 012.387-4.368M3 3l18 18"
                    stroke-width="2"/>`;
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                          9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>
