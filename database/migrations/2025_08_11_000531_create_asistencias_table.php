<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id')->nullable();
            $table->unsignedBigInteger('materia_id')->nullable();
            $table->unsignedBigInteger('curso_id')->nullable();
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->date('fecha');
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_salida')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
}
