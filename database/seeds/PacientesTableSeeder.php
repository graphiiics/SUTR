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

  		for($i=0; $i<30; $i++)
  		{ 
  			DB::table('pacientes')->insert([
  				'unidad_id' => rand(1,6),
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
