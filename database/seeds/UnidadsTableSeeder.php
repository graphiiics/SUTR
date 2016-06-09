<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UnidadsTableSeeder extends Seeder
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

  		for($i=0; $i<7; $i++)
  		{ 
  			DB::table('unidads')->insert([
  				'nombre' => $faker->randomElement($array = array ('Jerez','Tlatenago','San Agustin','Rio Grande','Real de Minas','Medica Norte','Almancen')),
  				'direccion' => $faker->address,
  				'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
