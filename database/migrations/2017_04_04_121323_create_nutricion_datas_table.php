<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutricionDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutricion_datas', function (Blueprint $table) {
            $table->increments('id');
            $tabla->integer('user_id')->unsigned();
            $tabla->float('grasa')->unsigned();
            $tabla->float('mm')->unsigned();
            $tabla->float('gv')->unsigned();
            $tabla->float('peso_seco')->unsigned();
            $tabla->float('glucosa')->unsigned();
            $tabla->float('urea')->unsigned();
            $tabla->float('creatinina')->unsigned();
            $tabla->float('acido_urico')->unsigned();
            $tabla->float('bun')->unsigned();
            $tabla->float('hb')->unsigned();
            $tabla->float('hto')->unsigned();
            $tabla->float('leucocitos')->unsigned();
            $tabla->float('albumina')->unsigned();
            $tabla->float('pts_totales')->unsigned();
            $tabla->float('colesterol')->unsigned();
            $tabla->float('trigleceridos')->unsigned();
            $tabla->float('potasio')->unsigned();
            $tabla->float('sodio')->unsigned();
            $tabla->float('fosforo')->unsigned();
            $tabla->float('calcio')->unsigned();
            $tabla->float('magnesio')->unsigned();
            $tabla->string('nifedipino');
            $tabla->string('acido_folico');
            $tabla->string('furosemida');
            $tabla->string('tribedoce');
            $tabla->string('omeprazol');
            $tabla->longtext('valoracion');
            $tabla->longtext('indicaciones');
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
        Schema::drop('nutricion_datas');
    }
}
