<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProveedorsTableSeeder extends Seeder
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

  		for($i=0; $i<15; $i++)
  		{ 
  			DB::table('proveedors')->insert([
  				'nombre' => $faker->company,
  				'gerente' => $faker->name,
  				'telefono' => $faker->phoneNumber,
  				'correo' => $faker->email,
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
