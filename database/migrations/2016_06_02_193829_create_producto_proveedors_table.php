<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_proveedors', function (Blueprint $table) {
            $table->increments('id');
<<<<<<< HEAD:database/migrations/2016_06_02_193829_create_producto_proveedors_table.php
            $table->integer('proveedor_id')->unsigned();
            $table->integer('producto_id')->unsigned();
=======
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
>>>>>>> f6bcb8072f0a381e371035737763d5b7690635c8:database/migrations/2016_03_11_020833_create_crecibos_table.php
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
        Schema::drop('producto_proveedors');
    }
}
