<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
<<<<<<< HEAD:database/migrations/2016_06_02_191512_create_productos_table.php
            $table->string('nombre');
            $table->string('precio');
            $table->string('categoria');
=======
            $table->date('fecha');
            $table->integer('paciente_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
>>>>>>> f6bcb8072f0a381e371035737763d5b7690635c8:database/migrations/2016_03_11_015615_create_sesions_table.php
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
        Schema::drop('productos');
    }
}
