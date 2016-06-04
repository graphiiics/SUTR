<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Producto_ventasTableSeeder extends Seeder
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

  		for($i=0; $i<1500; $i++)
  		{ 
  			DB::table('producto_ventas')->insert([
  				'venta_id' => rand(1,100),
  				'producto_id' => rand(1,15),
  				'cantidad' => rand(1,4),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
