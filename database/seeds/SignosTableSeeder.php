<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SignosTableSeeder extends Seeder
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

  		for($i=0; $i<750; $i++)
  		{ 
  			DB::table('signos')->insert([
  				'sesion_id' => rand(1,150),
  				'hora' => $faker->time($format = 'H:i:s', $max = 'now'),
	            't_a' => $faker->word,
	            'fc' => $faker->randomDigit,
	            'qs' => $faker->randomDigit,
	            'qd' => $faker->randomDigit,
	            'p-art' => $faker->randomDigit,
	            'p-ven' => $faker->randomDigit,
	            'ptm' => $faker->randomDigit,
	            'vel_uf' => $faker->randomDigit,
	            'uf_conseg' => $faker->randomDigit,
	            'soluciones' => $faker->text($maxNbChars = 30),
	            'observaciones' => $faker->text($maxNbChars = 30),
  				'created_at' => $faker->dateTime,
    		  	'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
