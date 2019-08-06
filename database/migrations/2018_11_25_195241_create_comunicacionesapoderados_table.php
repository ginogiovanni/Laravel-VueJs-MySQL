<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunicacionesapoderadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacionesapoderados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 180);
            $table->text('mensaje');
            $table->boolean('leido')->default(1);
            $table->boolean('estado')->default(1);
            $table->integer('idapoderado')->unsigned();
            $table->integer('idprofesor')->unsigned();

            $table->foreign('idapoderado')->references('id')->on('apoderados');
            $table->foreign('idprofesor')->references('id')->on('profesores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comunicacionesapoderados');
    }
}
