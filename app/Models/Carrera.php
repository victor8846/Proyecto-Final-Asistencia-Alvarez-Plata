<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

     protected $fillable = [
        'nombre', // ✅ Agrega aquí todos los campos que se permiten asignar en masa
    ];
     public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
    public function materias()
{
    return $this->hasMany(Materia::class);
}

}