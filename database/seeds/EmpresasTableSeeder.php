<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmpresasTableSeeder extends Seeder
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

  		for($i=0; $i<10; $i++)
  		{ 
  			DB::table('empresas')->insert([
  				'razon_social' => $faker->company,
  				'rfc' => $faker->swiftBicNumber,
  				'telefono' => $faker->phoneNumber,
  				'correo' => $faker->email,
  				'direccion' => $faker->address,
  				'created_at' => $faker->dateTime,
    		  'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
