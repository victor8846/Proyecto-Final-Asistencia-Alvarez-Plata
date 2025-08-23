<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    {{ $slot }}
            
            <!-- Logo -->
            <div class="hidden lg:block w-full max-w-2xl">
                <a href="/">
                    <img src="{{ asset('img/LOGO INSTITUTO.png') }}" 
                        alt="Logo" 
                        class="w-full h-auto rounded-lg shadow-2xl transform hover:scale-105 transition-transform duration-300">
                </a>
            </div>

           

    <!-- Contenedor del formulario -->
<div class="w-full max-w-md bg-white shadow-2xl rounded-2xl px-8 py-10 flex flex-col justify-center items-center">
    
    <!-- Título -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">SISTEMA DE CONTROL</h1>
        <p class="text-gray-500 mt-2">Bienvenido al sistema</p>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
        @csrf

        <!-- Campo Email con icono -->
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-600">
                <i class="fa-solid fa-user"></i>
            </span>
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}"
                   placeholder="Correo electrónico"
                   class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2 focus:ring-green-500 focus:border-green-500"
                   required autofocus>
        </div>

        <!-- Campo Contraseña con icono y botón mostrar -->
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-600">
                <i class="fa-solid fa-eye"></i>
            </span>
            <input id="password" 
                   name="password" 
                   type="password"
                   placeholder="Contraseña"
                   class="w-full border border-gray-300 rounded-md pl-10 pr-10 py-2 focus:ring-green-500 focus:border-green-500"
                   required>
            <!-- Botón mostrar/ocultar contraseña -->
            <button type="button" 
                    onclick="togglePasswordVisibility()"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-green-600 hover:text-green-800 focus:outline-none">
                <i id="eye-icon" class="fa-solid fa-eye"></i>
            </button>
        </div>

        <!-- Recordarme y Olvidaste contraseña -->
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" 
                       name="remember"
                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                <span class="text-gray-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-green-600 hover:text-green-800">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Botón de inicio de sesión -->
        <button type="submit" 
                class="w-full bg-green-600 text-black py-3 rounded-md hover:bg-green-700 transition">
            Iniciar sesión
        </button>
    </form>
</div>
        </div>
    </div>
</body>
</html>
