<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PedidosTableSeeder extends Seeder
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
  			DB::table('pedidos')->insert([
  				'unidad_id' => rand(1,6),
  				'user_id' => rand(1,5),
  				'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
  				'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
