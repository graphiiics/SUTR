<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 
class ComprasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

  		for($i=0; $i<100; $i++)
  		{ 
  			DB::table('compras')->insert([
  				'user_id' => rand(1,5),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'proveedor_id' => rand(1,15),
  				'importe'=> $faker->randomFloat($nbMaxDecimals = 0, $min = 50, $max = 999),
  				
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    
    }
}
