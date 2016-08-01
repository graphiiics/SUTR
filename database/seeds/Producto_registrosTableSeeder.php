<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class Producto_registrosTableSeeder extends Seeder
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
  			DB::table('producto_registros')->insert([
  				'registro_id' => rand(1,70),
  				'producto_id' => rand(1,50),
  				'cantidad' => rand(1,30),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
