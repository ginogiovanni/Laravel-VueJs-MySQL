<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariospersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuariospersonal', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idpersonal')->unsigned();            
            $table->foreign('idpersonal')->references('id')->on('personals')->onDelete('cascade');

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
        Schema::dropIfExists('usuariospersonal');
    }
}
