<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PacientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Faker::create();

  		for($i=0; $i<50; $i++)
  		{ 
  			DB::table('pacientes')->insert([
  				'unidad_id' => rand(2,7),
  				'nombre' => $faker->name,
  				'direccion' => $faker->address,
  				'telefono' => $faker->phoneNumber,
  				'celular' => $faker->phoneNumber,
  				'estatus' => rand(1,2),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
