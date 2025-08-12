@csrf

<div class="form-group">
    <label for="nombre">Nombre del curso</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
           value="{{ old('nombre', $curso->nombre ?? '') }}" required>
</div>

<div class="form-group">
    <label for="paralelo">Paralelo</label>
    <input type="text" name="paralelo" id="paralelo" class="form-control"
           value="{{ old('paralelo', $curso->paralelo ?? '') }}">
</div>

<div class="form-group">
    <label for="carrera_id">Carrera</label>
    <select name="carrera_id" id="carrera_id" class="form-control" required>
        <option value="">Seleccione una carrera</option>
        @foreach ($carreras as $carrera)
            <option value="{{ $carrera->id }}"
                {{ old('carrera_id', $curso->carrera_id ?? '') == $carrera->id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>
