<div class="mb-3">
    <label for="nombre" class="form-label">Nombre de la Materia</label>
    <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label for="carrera" class="form-label">Carrera</label>
    <input type="text" name="carrera" value="{{ old('carrera', $materia->carrera ?? '') }}" class="form-control" required>
</div>
