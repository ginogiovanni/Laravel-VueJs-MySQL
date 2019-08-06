<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunicacionescursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacionescursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 180);
            $table->text('mensaje');
            $table->boolean('estado')->default(1);
            $table->integer('idcurso')->unsigned();
            $table->integer('idprofesor')->unsigned();

            $table->foreign('idcurso')->references('id')->on('cursos');
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
        Schema::dropIfExists('comunicacionescursos');
    }
}
