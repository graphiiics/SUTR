<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RegistrosTableSeeder extends Seeder
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

  		for($i=0; $i<70; $i++)
  		{ 
  			DB::table('registros')->insert([
  				'user_id' => rand(1,5),
  				'unidad_id' => rand(1,7),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'tipo' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
