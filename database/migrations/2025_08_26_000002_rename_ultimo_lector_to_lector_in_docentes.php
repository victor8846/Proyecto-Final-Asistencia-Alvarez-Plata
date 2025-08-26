<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUltimoLectorToLectorInDocentes extends Migration
{
    public function up()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->renameColumn('ultimo_lector', 'lector');
        });
    }

    public function down()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->renameColumn('lector', 'ultimo_lector');
        });
    }
}
