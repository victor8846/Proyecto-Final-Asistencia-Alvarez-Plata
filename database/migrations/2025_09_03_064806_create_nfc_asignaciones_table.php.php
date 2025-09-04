<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nfc_asignaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id')->nullable();
            $table->unsignedBigInteger('docente_id')->nullable();
            $table->string('uid_nfc')->unique();
            $table->timestamps();

            // Relaciones
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('set null');
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfc_asignaciones');
    }
};
