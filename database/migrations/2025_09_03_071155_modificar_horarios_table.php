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
        Schema::table('horarios', function (Blueprint $table) {
             // Cambiar 'dia' a enum
            $table->enum('dia', ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'])->change();

            // Añadir índice único compuesto para evitar duplicidad de horarios en el mismo aula
            $table->unique(['aula_id', 'dia', 'hora_inicio'], 'horario_unico_por_aula');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
             // Revertir enum a string
            $table->string('dia')->change();

            // Eliminar índice único compuesto
            $table->dropUnique('horario_unico_por_aula');
        });
    }
};
