<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::create([
            'name' => 'Charles T Smith',
            'username' => 'Admin',
            'email' => 'charlestsmith888@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Admin123'),
        ]);
        $this->call(UserTableSeeder::class);
    }
}
