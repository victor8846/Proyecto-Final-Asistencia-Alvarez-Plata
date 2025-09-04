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
        Schema::table('estudiantes', function (Blueprint $table) {
           // Clave foránea a carreras
        $table->foreign('carrera_id')
              ->references('id')->on('carreras')
              ->onDelete('set null');

        // Clave foránea a cursos
        $table->foreign('curso_id')
              ->references('id')->on('cursos')
              ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['carrera_id']);
            $table->dropForeign(['curso_id']);
        });
    }
};
