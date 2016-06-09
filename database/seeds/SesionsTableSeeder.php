<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SesionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

  		for($i=0; $i<150; $i++)
  		{ 
  			DB::table('sesions')->insert([
  				'paciente_id' => rand(1,30),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now') ,
  				't_a_pie' => $faker->word,
	            'fc_pre' => $faker->randomDigit,
	            'peso_seco' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
	            't_apost' => $faker->word,
	            'fc_post' => $faker->randomDigit,
	            'peso_pre'=> $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
	            'peso_post' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
	            'peso_grando' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
	            'uf_programada' => $faker->randomDigit,
	            'acc_vasc' => $faker->word,
	            'alergias' => $faker->word,
	            'qs' => $faker->randomDigit,
	            'qd' => $faker->randomDigit,
	            'vsp' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
	            'ktv' => $faker->word,
	            'filtro' => $faker->word,
	            'reuso_n' => $faker->randomDigit,
	            'heparina' => $faker->randomDigit,
	            'na_b' => $faker->randomDigit,
	            'no_maquina' => $faker->randomDigit,
	            'na_presc' => $faker->randomDigit,
	            'bolo' => $faker->randomDigit,
	            'perfil_na' => $faker->randomDigit,
	            'ui_hr' => $faker->randomDigit,
	            'perfil_uf' => $faker->randomDigit,
	            'total' => $faker->randomDigit,
	            'conecto' => $faker->word,
	            'desconecto' => $faker->word,
	            'observaciones' => $faker->text($maxNbChars = 30),
	            'medicamentos' => $faker->text($maxNbChars = 30),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
