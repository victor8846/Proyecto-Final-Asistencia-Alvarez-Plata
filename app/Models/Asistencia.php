<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'curso_id',
        'carrera_id',
        'fecha',
        'hora_ingreso',
        'hora_salida',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}
