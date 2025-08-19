<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'email',
        'uid_nfc',
        'carrera_id',
        'curso_id',
        'ultimo_lector',
        'fecha_registro'
    ];

    // Relación con la tabla carreras
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    // Relación con la tabla cursos
    public function curso()
    {
         return $this->belongsTo(Curso::class,);
    }

    // Relación con tarjeta NFC si la tienes
    public function tarjetaNfc()
    {
        return $this->hasOne(TarjetaNfc::class);
    }

    // Atributo personalizado para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }
}
