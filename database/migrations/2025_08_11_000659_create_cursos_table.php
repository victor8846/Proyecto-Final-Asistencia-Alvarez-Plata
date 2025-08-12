<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre', 100); // Nombre del curso
            $table->string('paralelo', 100)->nullable(); 
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade'); // clave foránea carrera_id
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
