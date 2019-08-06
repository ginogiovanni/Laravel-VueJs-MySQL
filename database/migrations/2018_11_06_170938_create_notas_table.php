<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('nota1', 2,1);
            $table->decimal('nota2', 2,1);
            $table->decimal('nota3', 2,1);
            $table->decimal('nota4', 2,1);
            $table->decimal('nota5', 2,1);
            $table->decimal('nota6', 2,1);
            $table->decimal('nota7', 2,1);
            $table->decimal('nota8', 2,1);
            $table->decimal('nota9', 2,1);
            $table->decimal('nota10', 2,1);
            $table->decimal('nota11', 2,1);
            $table->decimal('nota12', 2,1);
            $table->string('semestre', 40);           
            $table->boolean('condicion')->default(1);
            $table->integer('idasignatura')->unsigned();
            $table->integer('idalumno')->unsigned();
        
            $table->foreign('idasignatura')->references('id')->on('asignaturas');
            $table->foreign('idalumno')->references('id')->on('alumnos');
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
        Schema::dropIfExists('notas');
    }
}
