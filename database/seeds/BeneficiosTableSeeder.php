<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BeneficiosTableSeeder extends Seeder
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

  		for($i=0; $i<20; $i++)
  		{ 
  			$beneficio_id = DB::table('beneficios')->insertGetId([
  				'user_id' => rand(1,2),
  				'paciente_id' => rand(1,50),
  				'empresa_id' => rand(1,10),
  				'unidad_id' => rand(1,6),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'sesiones' => rand(3,10),
  				'cantidad' => $faker->numberBetween($min = 1000, $max = 9000),
  				'sesiones_realizadas' => rand(3,10),
  				'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);

       

          	DB::table('cbeneficios')->insert([
          		'beneficio_id' => $beneficio_id,
      				'user_id' => rand(1,2),
      				'paciente_id' => rand(1,30),
      				'empresa_id' => rand(1,10),
      				'unidad_id' => rand(1,6),
      				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
      				'sesiones' => rand(3,10),
      				'cantidad' => $faker->numberBetween($min = 1000, $max = 9000),
      				'sesiones_realizadas' => rand(3,10),
      				'estatus' => rand(1,2),
      				'created_at' => $faker->dateTime,
        		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}

//php artisan make:seeder BeneficiosTableSeeder