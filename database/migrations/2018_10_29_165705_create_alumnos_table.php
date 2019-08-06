<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut', 15)->unique();
            $table->string('nombre', 80);
            $table->date('fecha_nac');
            $table->integer('edad');
            $table->string('direccion', 90);
            $table->integer('idcomuna')->unsigned();
            $table->integer('idcurso')->unsigned();
            $table->integer('idapoderado')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idcomuna')->references('id')->on('comunas');
            $table->foreign('idcurso')->references('id')->on('cursos');
            $table->foreign('idapoderado')->references('id')->on('apoderados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
