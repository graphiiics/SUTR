<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('estatus');
<<<<<<< HEAD:database/migrations/2016_06_02_015003_create_conceptos_table.php
=======
            $table->integer('beneficio_id')->unsigned();
            $table->foreign('beneficio_id')->references('id')->on('beneficios');
>>>>>>> f6bcb8072f0a381e371035737763d5b7690635c8:database/migrations/2016_03_11_012108_create_conceptos_table.php
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
        Schema::drop('conceptos');
    }
}
