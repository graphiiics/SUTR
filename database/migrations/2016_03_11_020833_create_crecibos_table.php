<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crecibos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recibo_id')->unsigned();
            $table->integer('concepto_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->integer('unidad_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->integer('estatus');
            $table->foreign('unidad_id')->references('id')->on('unidads');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('concepto_id')->references('id')->on('conceptos');
             $table->foreign('recibo_id')->references('id')->on('recibos')
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
        Schema::drop('crecibos');
    }
}
