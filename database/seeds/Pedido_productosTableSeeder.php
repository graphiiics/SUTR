<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Pedido_productosTableSeeder extends Seeder
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

  		for($i=0; $i<1000; $i++)
  		{ 
  			DB::table('pedido_productos')->insert([
  				'pedido_id' => rand(1,20),
  				'producto_id' => rand(1,50),
  				'cantidad' => rand(1,30),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
