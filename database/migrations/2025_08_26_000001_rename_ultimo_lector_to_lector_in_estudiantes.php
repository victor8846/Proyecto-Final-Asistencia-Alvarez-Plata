<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUltimoLectorToLectorInEstudiantes extends Migration
{
    public function up()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->renameColumn('ultimo_lector', 'lector');
        });
    }

    public function down()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->renameColumn('lector', 'ultimo_lector');
        });
    }
}
