<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nfc_asignacion_id'); // Vincula la tarjeta NFC
            $table->unsignedBigInteger('horario_id');         // Vincula el horario de la clase
            $table->timestamp('hora_ingreso')->nullable();
            $table->timestamp('hora_salida')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('nfc_asignacion_id')->references('id')->on('nfc_asignaciones')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
