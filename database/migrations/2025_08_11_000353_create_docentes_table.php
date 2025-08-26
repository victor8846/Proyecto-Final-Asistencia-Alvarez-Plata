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
            $table->unsignedBigInteger('materia_id')->nullable();
            $table->unsignedBigInteger('carrera_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
