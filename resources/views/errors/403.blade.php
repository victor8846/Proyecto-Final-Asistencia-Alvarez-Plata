@extends('layouts.adminlte')

@section('title', 'Acceso denegado')

@section('content')
<div class="container-fluid text-center">
    <h1 class="text-danger">403</h1>
    <h3>No tienes permisos para acceder a esta sección.</h3>
    <a href="{{ url('/dashboard') }}" class="btn btn-primary mt-3">Volver al dashboard</a>
</div>
@endsection
