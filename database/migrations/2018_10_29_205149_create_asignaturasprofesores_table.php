<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignaturasprofesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturasprofesores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idprofesor')->unsigned();
            $table->integer('idasignatura')->unsigned();
            $table->integer('idcurso')->unsigned();
            $table->string('dia', 10);
            $table->string('hora_inicio', 10);
            $table->string('hora_fin', 10);
            $table->string('semestre', 40);
            $table->boolean('jefe')->default(1);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idprofesor')->references('id')->on('profesores');
            $table->foreign('idasignatura')->references('id')->on('asignaturas');
            $table->foreign('idcurso')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaturasprofesores');
    }
}
