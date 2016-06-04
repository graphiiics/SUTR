<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sesion_id')->unsigned();
            $table->time('hora');
            $table->string('t_a');
            $table->integer('fc');
            $table->integer('qs');
            $table->integer('qd');
            $table->integer('p-art');
            $table->integer('p-ven');
            $table->integer('ptm');
            $table->integer('vel_uf');
            $table->integer('uf_conseg');
            $table->string('soluciones');
            $table->string('observaciones');
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
        Schema::drop('signos');
    }
}
