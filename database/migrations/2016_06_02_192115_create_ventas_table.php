<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('fecha');
            $table->integer('pago');
            $table->string('cliente');
            $table->double('importe');
            $table->integer('estatus');
            $table->date('fecha_liquidacion')->default('0000-00-00');
            $table->boolean('corte')->default(false);
            $table->date('fecha_corte')->default('0000-00-00');
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
        Schema::drop('ventas');
    }
}
