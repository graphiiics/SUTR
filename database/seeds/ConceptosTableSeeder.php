<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ConceptosTableSeeder extends Seeder
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

  		for($i=0; $i<4; $i++)
  		{ 
  			DB::table('conceptos')->insert([
  				'nombre' => $faker->randomElement($array = array ('Efectivo','Beneficencia','Cortesia')),
  				'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
