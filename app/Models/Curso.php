<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'paralelo', 'carrera_id'];

    // Relación con carrera (muchos a uno)
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    // Relación con materias (muchos a muchos) — si aplicara
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'curso_materia_profesor')
                    ->withPivot('profesor_id', 'dia')
                    ->withTimestamps();
    }

    // Relación con asignaciones — si aplicara
    public function asignaciones()
    {
        return $this->hasMany(DocenteMateriaCurso::class);
    }
    public function estudiantes()
{
    return $this->hasMany(Estudiante::class);
}
public function getNombreCompletoAttribute()
{
      return $this->curso . $this->paralelo;

}

}