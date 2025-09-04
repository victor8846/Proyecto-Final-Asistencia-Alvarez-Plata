<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('estudiante_id')->nullable()
                  ->constrained('estudiantes')
                  ->onDelete('cascade');

            $table->foreignId('materia_id')->nullable()
                  ->constrained('materias')
                  ->onDelete('cascade');

            $table->foreignId('curso_id')->nullable()
                  ->constrained('cursos')
                  ->onDelete('cascade');

            $table->foreignId('carrera_id')->nullable()
                  ->constrained('carreras')
                  ->onDelete('cascade');

            // Campos propios de asistencias
            $table->date('fecha');
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_salida')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            //
        });
    }
};
