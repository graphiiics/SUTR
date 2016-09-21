<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RecibosTableSeeder extends Seeder
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

  		for($i=0; $i<720; $i++)
  		{ 
  			$recibo_id = DB::table('recibos')->insertGetId([
  				'tipo_pago' => $faker->randomElement($array = array ('Efectivo','Voluntariado','Obispado','Beneficencia')),
  				'paciente_id' => rand(1,30),
  				'unidad_id' => rand(1,6),
  				'user_id' => rand(1,5),
  				'beneficio_id' => rand(0,20),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'cantidad' => $faker->numberBetween($min = 800, $max = 1200),
  				'estatus' => rand(1,3),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);

          // 	DB::table('crecibos')->insert([
          //     'recibo_id' => $recibo_id,
      				// 'concepto_id' => rand(1,4),
      				// 'paciente_id' => rand(1,30),
      				// 'unidad_id' => rand(1,6),
      				// 'user_id' => rand(1,5),
      				// 'beneficio_id' => rand(1,120),
      				// 'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
      				// 'cantidad' => $faker->numberBetween($min = 800, $max = 1200),
      				// 'estatus' => rand(1,3),
      				// 'created_at' => $faker->dateTime,
        		//   'updated_at' => $faker->dateTime
          // 	]);
    }
  }

}
