@extends('layouts.adminlte')

@section('title', 'Seleccionar Horario')

@section('content')
    <h3>Selecciona Carrera y Curso</h3>

    <form action="{{ route('horarios.ver', ['carrera' => 0, 'curso' => 0]) }}" method="GET" onsubmit="return enviar()">
        <div class="row">
            <div class="col-md-5">
                <label>Carrera</label>
                <select id="carrera_id" name="carrera" class="form-control" required>
                    <option value="">Seleccionar</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label>Curso</label>
                <select id="curso_id" name="curso" class="form-control" required>
                    <option value="">Seleccionar</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}">{{ $curso->nivel }}{{ $curso->paralelo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Ver Horario</button>
            </div>
        </div>
    </form>

    <script>
        function enviar() {
            const carrera = document.getElementById('carrera_id').value;
            const curso = document.getElementById('curso_id').value;
            if (!carrera || !curso) return false;
            const url = "{{ url('horario') }}/" + carrera + "/" + curso;
            window.location.href = url;
            return false;
        }
    </script>
@stop
