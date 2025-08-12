@extends('layouts.adminlte')
@section('title', 'Carreras')

@section('content_header')
    <h1>Gestión de Carreras</h1>
@endsection

@section('content')
    <a href="{{ route('carreras.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Nueva Carrera
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover">
            <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carreras as $carrera)
                        <tr>
                            <td>{{ $carrera->id }}</td>
                            <td>{{ $carrera->nombre }}</td>
                            <td>
                                <a href="{{ route('carreras.edit', $carrera->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('carreras.destroy', $carrera->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas eliminar esta carrera?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($carreras->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay carreras registradas.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
