@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid">
    <h1>Dashboard</h1>
    <p>Bienvenido {{ Auth::user()->name }}</p>
  </div>
@endsection

@section('scripts')
  @if(session('bienvenida'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '{{ session('bienvenida') }}',
            text: 'Nos alegra tenerte de vuelta.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
  @endif
@endsection
