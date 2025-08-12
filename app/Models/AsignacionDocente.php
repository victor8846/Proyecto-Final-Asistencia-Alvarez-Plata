<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionDocente extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id',
        'materia_id',
        'curso_id',
        'carrera_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    // Relaciones

    public function docente()
    {
        return $this->belongsTo(Docente::class);
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
