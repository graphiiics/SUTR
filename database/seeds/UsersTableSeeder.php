<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);
     * @return void
     *///
        
    public function run()
    {
    
      $faker = Faker::create();

  		for($i=0; $i<5; $i++)
  		{ 
  			DB::table('users')->insert([
              'name' => $faker->name,
              'email' => $faker->unique()->email,
              'password' => bcrypt('hemodialisis'),
              'estatus' => rand(1,2),
              'telefono' => $faker->PhoneNumber,
              'foto' => $faker->imageUrl($width = 240, $height = 260, 'people'),
              'tipo' => rand(1,3),
              'unidad_id'=>rand(1,7),
              'remember_token' => str_random(10),
              'created_at' => $faker->dateTime,
    			'updated_at' => $faker->dateTime
          	]);
  		}
    }
}
