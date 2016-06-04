<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbeneficiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbeneficios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beneficio_id')->unsigned();
<<<<<<< HEAD:database/migrations/2016_06_02_021846_create_cbeneficios_table.php
            $table->integer('user_id')->unsigned();;
            $table->integer('paciente_id')->unsigned();;
            $table->integer('empresa_id')->unsigned();;
            $table->integer('unidad_id')->unsigned();
=======
            $table->integer('user_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->integer('empresa_id')->unsigned();
>>>>>>> f6bcb8072f0a381e371035737763d5b7690635c8:database/migrations/2016_03_11_020820_create_cbeneficios_table.php
            $table->date('fecha');
            $table->integer('sesiones');
            $table->double('cantidad');
            $table->integer('estatus');
            $table->integer('sesiones_realizadas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('beneficio_id')->references('id')->on('beneficios');

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
        Schema::drop('cbeneficios');
    }
}
