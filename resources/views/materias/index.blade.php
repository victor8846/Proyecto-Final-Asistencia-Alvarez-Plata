@extends('layouts.adminlte')

@section('title', 'Materias')

@section('content_header')
    <h1>Listado de Materias</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
    <div class="row mb-3">
        <!-- Botón Registrar Materia -->
        <div class="col-md-4 mb-2">
            <a href="{{ route('materias.create') }}" class="btn btn-primary w-100">
                <i class="fas fa-plus-circle"></i> Registrar Materia
            </a>
        </div>

        <!-- Formulario de filtros y exportación -->
        <div class="col-md-8">
            <form method="GET" action="{{ route('materias.index') }}" class="form-inline justify-content-end flex-wrap">
                <select name="carrera_id" class="form-control mb-2 mr-2">
                    <option value="">-- Todas las Carreras --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary mb-2 mr-2">Filtrar</button>
                <a href="{{ route('materias.index') }}" class="btn btn-outline-secondary mb-2 mr-2">Limpiar</a>

                <a href="{{ route('materias.exportar.pdf', ['carrera_id' => request('carrera_id')]) }}"
                   class="btn btn-danger mb-2 mr-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('materias.exportar.excel', ['carrera_id' => request('carrera_id')]) }}"
                   class="btn btn-success mb-2" target="_blank">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </form>
        </div>
    </div>
</div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                     <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materias as $key => $materia)
                            <tr>
                                <td>{{ $materias->firstItem() + $key }}</td>
                                <td>{{ $materia->nombre }}</td>
                                <td>{{ $materia->carrera->nombre ?? 'Sin carrera' }}</td>
                                <td>
                                    <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" class="d-inline-block"
                                          onsubmit="return confirm('¿Deseas eliminar esta materia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay materias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $materias->links() }}
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .pagination {
        font-size: 0.9rem;
    }
    .pagination .page-link {
        padding: 0.4rem 0.6rem;
    }
</style>
@endpush
