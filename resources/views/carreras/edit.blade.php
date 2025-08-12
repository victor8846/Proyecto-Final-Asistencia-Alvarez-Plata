@extends('layouts.adminlte')
@section('title', 'Editar Carrera')

@section('content_header')
    <h1>Editar Carrera</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('carreras.update', $carrera->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre de la carrera</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $carrera->nombre }}" required>
                </div>

                <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Carrera</button>
            </form>
        </div>
    </div>
@stop