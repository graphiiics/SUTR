<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Producto_unidadsTableSeeder extends Seeder
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
        $unidad=1;
        $producto=1;
  		for($i=0; $i<350; $i++)
  		{
       
        if($producto>50){
          $producto=1;
          $unidad++;
        }
  			DB::table('producto_unidads')->insert([
  				'unidad_id' => $unidad,
  				'producto_id' => $producto,
  				'cantidad' => rand(1,30),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
        
        $producto++;
  		}
    }
}
