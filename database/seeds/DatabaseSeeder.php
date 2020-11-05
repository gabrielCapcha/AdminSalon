<?php

use Illuminate\Database\Seeder;
use App\Models\People;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
   {
      $faker = Faker\Factory::create('es_ES');

      for($a = 0; $a < 95; $a++) {
         $user = People::create(array(
            'names' => $faker->firstname . ' ' . $faker->lastname,  
            'gender' => rand(0, 2),
            'address' => $faker->address,
            'city' => $faker->city,
            'civil_status' => rand(0,3),
            'document' => $faker->numberBetween(11111111,99999999999)
         ));
      }
   }
}
