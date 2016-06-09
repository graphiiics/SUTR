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
            $table->integer('paciente_id')->unsigned();
            $table->integer('unidad_id')->unsigned();
            $table->integer('concepto_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('beneficio_id')->unsigned();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->integer('estatus');
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
