<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recibo_id')->unsigned();
            $table->date('fecha');
            $table->string('t_a_pie');
            $table->integer('fc_pre');
            $table->double('peso_seco');
            $table->string('t_apost');
            $table->integer('fc_post');
            $table->double('peso_pre');
            $table->double('peso_post');
            $table->double('peso_grando');
            $table->integer('uf_programada');
            $table->string('acc_vasc');
            $table->string('alergias');
            $table->integer('qs');
            $table->integer('qd');
            $table->double('vsp');
            $table->string('ktv');
            $table->string('filtro');
            $table->integer('reuso_n');
            $table->integer('heparina');
            $table->integer('na_b');
            $table->integer('no_maquina');
            $table->integer('na_presc');
            $table->integer('bolo');
            $table->integer('perfil_na');
            $table->integer('ui_hr');
            $table->integer('perfil_uf');
            $table->integer('total');
            $table->string('conecto');
            $table->string('desconecto');
            $table->string('observaciones');
            $table->string('medicamentos');
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
        Schema::drop('sesions');
    }
}
