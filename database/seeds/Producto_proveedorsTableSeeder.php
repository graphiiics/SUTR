<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Producto_proveedorsTableSeeder extends Seeder
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

  		for($i=0; $i<750; $i++)
  		{ 
  			DB::table('producto_proveedors')->insert([
  				'proveedor_id' => rand(1,15),
  				'producto_id' => rand(1,50),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
