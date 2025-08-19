<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nfc_lecturas', function (Blueprint $table) {
            $table->id();
            $table->string('uid_nfc')->unique(); // UID de la tarjeta
            $table->string('lector')->nullable(); // Nombre del lector
            $table->boolean('confirmado')->default(false); // Si ya se confirmó
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfc_lecturas');
    }
};
