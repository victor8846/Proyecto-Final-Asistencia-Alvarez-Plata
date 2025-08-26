<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cambiar Contraseña') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('message'))
                        <div class="mb-4 font-medium text-sm text-yellow-600">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf

                        <!-- Current Password -->
                        <div>
                            <x-input-label for="current_password" :value="__('Contraseña Actual')" />
                            <x-text-input id="current_password" class="block mt-1 w-full"
                                        type="password"
                                        name="current_password"
                                        required />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>

                        <!-- New Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Nueva Contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation"
                                        required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Cambiar Contraseña') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
