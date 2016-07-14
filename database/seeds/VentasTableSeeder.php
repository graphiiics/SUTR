<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VentasTableSeeder extends Seeder
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

  		for($i=0; $i<100; $i++)
  		{ 
  			DB::table('ventas')->insert([
  				'user_id' => rand(1,5),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'cliente' => $faker->name,
  				'importe'=> $faker->randomFloat($nbMaxDecimals = 0, $min = 50, $max = 999),
  				'pago' => rand(1,2),
          'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
