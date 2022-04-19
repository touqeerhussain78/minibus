<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boolean = [true, false];
        //$faker = new Faker();
        $faker = \Faker\Factory::create();

        $users = factory(\App\User::class, 20)->create();
    }
}
