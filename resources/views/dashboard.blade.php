@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Dashboard</h1>
                </div>
                <div class="card-body">
                    @auth
                        <p class="mb-0">Bienvenido, <strong>{{ Auth::user()->name }}</strong></p>
                    @else
                        <p class="mb-0">Por favor, inicia sesión para acceder al sistema.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(session('bienvenida'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mensaje = "{{ session('bienvenida') }}";
            const swalConfig = {
                title: '¡Bienvenido!',
                text: mensaje,
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#28a745'
            };
            Swal.fire(swalConfig);
        });
    </script>
@endif
@endsection
