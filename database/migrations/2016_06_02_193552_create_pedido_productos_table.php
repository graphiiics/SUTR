<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pedido_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('cantidad');
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
        Schema::drop('pedido_productos');
    }
}
