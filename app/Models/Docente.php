<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

     protected $table = 'docentes';

    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'ci', 'email', 'materia_id', 'carrera_id', 'lector', 'fecha_registro'];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    // Relación uno a muchos con las asignaciones
  
    
}
