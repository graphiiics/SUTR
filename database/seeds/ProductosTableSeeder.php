<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductosTableSeeder extends Seeder
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

  		for($i=0; $i<50; $i++)
  		{ 
  			DB::table('productos')->insert([
  				'nombre' => $faker->word,
  				'precio'=> $faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 999),
  				'categoria' => $faker->randomElement($array = array ('medicamento','suplemento','material')),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
