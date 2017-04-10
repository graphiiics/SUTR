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
            $table->integer('paciente_id')->unsigned();
            $table->float('grasa')->unsigned();
            $table->float('mm')->unsigned();
            $table->float('agua')->unsigned();
            $table->float('gv')->unsigned();
            $table->float('peso_seco')->unsigned();
            $table->float('glucosa')->unsigned();
            $table->float('urea')->unsigned();
            $table->float('creatinina')->unsigned();
            $table->float('acido_urico')->unsigned();
            $table->float('bun')->unsigned();
            $table->float('hb')->unsigned();
            $table->float('hto')->unsigned();
            $table->float('leucocitos')->unsigned();
            $table->float('albumina')->unsigned();
            $table->float('pts_totales')->unsigned();
            $table->float('colesterol')->unsigned();
            $table->float('trigleceridos')->unsigned();
            $table->float('potasio')->unsigned();
            $table->float('sodio')->unsigned();
            $table->float('fosforo')->unsigned();
            $table->float('calcio')->unsigned();
            $table->float('magnesio')->unsigned();
            $table->string('nifedipino');
            $table->string('acido_folico');
            $table->string('furosemida');
            $table->string('tribedoce');
            $table->string('omeprazol');
            $table->longtext('valoracion');
            $table->longtext('indicaciones');
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
