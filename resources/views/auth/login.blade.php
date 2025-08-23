<x-guest-layout>
    <div class="flex flex-col min-h-screen bg-gradient-to-br from-green-100 to-blue-100">
        <div class="flex-grow flex items-center justify-center py-8">
            <div class="flex flex-col md:flex-row bg-white/90 rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl">
                <!-- Imagen a la izquierda -->
                <div class="md:w-1/2 flex items-center justify-center bg-emerald-800/15 backdrop-blur-sm p-8">
                    <img src="{{ asset('img/LOGO INSTITUTO.png') }}" alt="Logo" class="max-h-64 w-auto rounded-lg shadow-lg">
                </div>
                <!-- Formulario a la derecha -->
                <div class="md:w-1/2 p-8 flex flex-col justify-center">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-green-700 break-words">SISTEMA DE CONTROL INCOS</h1>
                        <p class="text-gray-500 mt-2">Bienvenido al sistema</p>
                    </div>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('login') }}" class="space-y-8">
                        @csrf
                        <div class="relative mb-4">
                            <input type="email" id="email" name="email" placeholder="Correo electrónico"
                                   class="w-full pl-4 pr-12 py-4 rounded-lg border border-gray-300 bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                                   value="{{ old('email') }}" required autofocus>
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8.962 8.962 0 0112 15c2.485 0 4.735.994 6.379 2.618M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="relative mb-4">
                            <input type="password" name="password" id="password" placeholder="Contraseña"
                                   class="w-full pl-4 pr-12 py-4 rounded-lg border border-gray-300 bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                                   required>
                            <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-500 focus:outline-none">
                                Mostrar
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-blue-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-800 text-white py-5 px-8 text-xl rounded-lg font-semibold hover:from-green-700 hover:to-green-900 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02] shadow-lg">
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="bg-green-900/90 text-white py-4 mt-auto shadow-inner">
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
                <div class="mb-2 md:mb-0 text-center md:text-left">
                    &copy; {{ date('Y') }} Instituto Tecnológico Nacional de Comercio "INCOS". Todos los derechos reservados.
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="https://www.facebook.com/incoscbba?locale=es_LA" target="_blank" class="hover:text-blue-400" title="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.6 0 0 .6 0 1.326v21.348C0 23.4.6 24 1.326 24H12.82v-9.294H9.692V11.01h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.92.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.696h-3.12V24h6.116C23.4 24 24 23.4 24 22.674V1.326C24 .6 23.4 0 22.675 0"/></svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="hover:text-blue-300" title="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.93 9.93 0 01-2.828.775 4.932 4.932 0 002.165-2.724c-.951.564-2.005.974-3.127 1.195a4.92 4.92 0 00-8.384 4.482C7.691 8.095 4.066 6.13 1.64 3.161c-.542.929-.856 2.01-.857 3.17 0 2.188 1.115 4.117 2.823 5.254a4.904 4.904 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 01-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 010 21.543a13.94 13.94 0 007.548 2.209c9.058 0 14.009-7.513 14.009-14.009 0-.213-.005-.425-.014-.636A10.012 10.012 0 0024 4.557z"/></svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="hover:text-pink-400" title="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.775.13 4.602.402 3.635 1.37c-.967.967-1.24 2.14-1.298 3.417C2.013 8.332 2 8.741 2 12c0 3.259.013 3.668.072 4.948.058 1.277.331 2.45 1.298 3.417.967.967 2.14 1.24 3.417 1.298C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.277-.058 2.45-.331 3.417-1.298.967-.967 1.24-2.14 1.298-3.417.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.058-1.277-.331-2.45-1.298-3.417-.967-.967-2.14-1.24-3.417-1.298C15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/></svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</x-guest-layout>
