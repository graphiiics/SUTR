<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposToNutricionDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('nutricion_datas', function (Blueprint $table) {
            $table->float('imc')->unsigned();
            $table->float('estatura')->unsigned();
            $table->float('cmb')->unsigned();
            $table->float('c_m')->unsigned();
            $table->float('pct')->unsigned();
            $table->float('complexion')->unsigned();
            $table->float('ambd')->unsigned();
            $table->float('vcm')->unsigned();
            $table->float('wbc')->unsigned();
            $table->float('rbc')->unsigned();
            $table->float('plq')->unsigned();
            $table->float('globulinas')->unsigned();
            $table->float('hdl')->unsigned();
            $table->float('ldl')->unsigned();
            $table->float('vldl')->unsigned();
            $table->float('cloro')->unsigned();
            $table->longtext('exploracion_fisica');
            $table->longtext('valoracion_medica');
            $table->longtext('indicaciones_medicas');
            $table->longtext('nota_medica');
            $table->longtext('valoracion_nutricional_seguimiento');
            $table->integer('cambio_de_peso');
            $table->integer('ingesta_dietetica');
            $table->integer('sintomas_gastrointestinales');
            $table->integer('capacidad_funcional');
            $table->integer('comorbilidades');
            $table->integer('examen_fisico');
            $table->integer('signos_perdida_muscular');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nutricion_datas', function (Blueprint $table) {
            $table->dropColumn(['imc','estatura','cmb','c_m','pct','complexion',
                'ambd','vcm','wbc','rbc','plq','globulinas','hdl','ldl','vldl',
                'cloro','exploracion_fisica','valoracion_medica','indicaciones_medicas','nota_medica',
                'valoracion_nutricional_seguimiento',
                'cambio_de_peso', 'ingesta_dietetica', 'sintomas_gastrointestinales', 'capacidad_funcional',
                'comorbilidades','examen_fisico','signos_perdida_muscular']);
        });
    }
}
