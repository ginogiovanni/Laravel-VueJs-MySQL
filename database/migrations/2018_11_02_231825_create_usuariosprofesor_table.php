<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosprofesorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuariosprofesor', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idprofesor')->unsigned();            
            $table->foreign('idprofesor')->references('id')->on('profesores')->onDelete('cascade');

            $table->integer('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users');

            //$table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuariosprofesor');
    }
}
