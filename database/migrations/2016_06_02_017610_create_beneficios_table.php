<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->integer('empresa_id')->unsigned();
            $table->integer('unidad_id')->unsigned();
            $table->integer('concepto_id')->unsigned();
            $table->date('fecha');
            $table->integer('sesiones');
            $table->double('cantidad');
            $table->integer('estatus')->default(1); //1Activo //2 Desactivado
            $table->integer('sesiones_realizadas');
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
        Schema::drop('beneficios');
    }
}
