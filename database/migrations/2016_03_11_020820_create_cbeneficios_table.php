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
            $table->integer('beneficio_id');
            $table->integer('user_id');
            $table->integer('paciente_id');
            $table->integer('empresa_id');
            $table->date('fecha');
            $table->integer('sesiones');
            $table->double('cantidad');
            $table->integer('estatus');
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
        Schema::drop('cbeneficios');
    }
}
