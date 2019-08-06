<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosapoderadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuariosapoderados', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idapoderado')->unsigned();
            $table->foreign('idapoderado')->references('id')->on('apoderados')->onDelete('cascade');

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
        Schema::dropIfExists('usuariosapoderados');
    }
}
