<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apoderados', function (Blueprint $table) {
            $table->string('rut', 15)->unique();
            $table->string('nombre', 80);
            $table->date('fecha_nac');
            $table->integer('edad');
            $table->string('direccion', 90);
            $table->string('telefono', 25);
            $table->string('correo', 100);
            $table->integer('idcomuna')->unsigned();
            $table->boolean('condicion')->default(1);

            $table->foreign('idcomuna')->references('id')->on('comunas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apoderados', function (Blueprint $table) {
            $table->string('rut', 15)->unique();
            $table->string('nombre', 80);
            $table->date('fecha_nac');
            $table->integer('edad');
            $table->string('direccion', 90);
            $table->string('telefono', 25);
            $table->string('correo', 100);
            $table->integer('idcomuna')->unsigned();
            $table->boolean('condicion')->default(1);

            $table->foreign('idcomuna')->references('id')->on('comunas');
        });
    }
}
