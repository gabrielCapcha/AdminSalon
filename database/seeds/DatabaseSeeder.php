<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'  => 'Margoth Anaya',
            'email'     => 'amargoth4@gmail.com',
            'password'  => bcrypt('123456'),
        ]);
    }
}
