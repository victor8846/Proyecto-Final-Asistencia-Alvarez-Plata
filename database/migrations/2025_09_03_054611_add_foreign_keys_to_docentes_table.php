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
        Schema::table('docentes', function (Blueprint $table) {
           // Clave foránea a materias
        $table->foreign('materia_id')
              ->references('id')->on('materias')
              ->onDelete('set null');

        // Clave foránea a carreras
        $table->foreign('carrera_id')
              ->references('id')->on('carreras')
              ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign(['materia_id']);
            $table->dropForeign(['carrera_id']);
        });
    }
};
