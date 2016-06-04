<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidad_id')->unsigned();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('celular');
            $table->integer('estatus');
<<<<<<< HEAD:database/migrations/2016_06_02_014716_create_pacientes_table.php
=======
            $table->integer('unidad_id')->unsigned();
            $table->foreign('unidad_id')->references('id')->on('unidads');
>>>>>>> f6bcb8072f0a381e371035737763d5b7690635c8:database/migrations/2016_03_11_011952_create_pacientes_table.php
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
        Schema::drop('pacientes');
    }
}
