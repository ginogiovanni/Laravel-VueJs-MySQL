<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNombreCardinalToRegiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regiones', function (Blueprint $table) {
            $table->string('nombre_ordinal', 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regiones', function (Blueprint $table) {
            $table->dropColumn('nombre_ordinal', 4);
        });
    }
}
