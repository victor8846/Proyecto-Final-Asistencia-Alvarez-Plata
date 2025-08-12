<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

   protected $fillable = [
        'carrera_id',
        'curso_id',
        'asignacion_docente_id',
        'aula_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    // Relaciones
    public function carrera() {
        return $this->belongsTo(Carrera::class);
    }

    public function curso() {
        return $this->belongsTo(Curso::class);
    }

    public function asignacionDocente() {
        return $this->belongsTo(AsignacionDocente::class);
    }

    public function aula() {
        return $this->belongsTo(Aula::class);
    }
}
