@extends('layouts.adminlte')
@section('title', 'Nueva Carrera')

@section('content_header')
    <h1>Registrar Nueva Carrera</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('carreras.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre de la carrera</label>
                    <input type="text" name="nombre" class="form-control" required placeholder="Ej. Ingeniería de Sistemas">
                </div>

                <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Carrera</button>
            </form>
        </div>
    </div>
@stop