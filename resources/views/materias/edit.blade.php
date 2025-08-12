@extends('layouts.adminlte')

@section('title', 'Editar Materia')

@section('content_header')
    <h1>Editar Materia</h1>
@stop
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('materias.update', $materia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre de la Materia</label>
                <input type="text" name="nombre" class="form-control" value="{{ $materia->nombre }}" required>
            </div>

            <div class="form-group">
                <label for="carrera_id">Carrera</label>
                <select name="carrera_id" class="form-control" required>
                    @foreach ($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ $materia->carrera_id == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@stop
