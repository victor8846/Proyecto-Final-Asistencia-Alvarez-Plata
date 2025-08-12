<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('ci', 20)->unique();
            $table->string('email', 100)->nullable();
            $table->string('uid_nfc', 20)->nullable()->unique();
            $table->string('ultimo_lector')->nullable();
            $table->timestamp('fecha_registro')->nullable();
            // Claves foráneas
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
