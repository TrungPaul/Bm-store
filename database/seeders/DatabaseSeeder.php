<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();

        $this->makeAdmin();
    }

    private function makeAdmin()
    {
        User::create(
            [
                [
                    'name' => 'dungvn',
                    'email' => 'dungvn.dev@gmail.com',
                    'phone' => '1234567890',
                    'password' => Hash::make('123456'),
                    'type' => 1, //admin
                    'status' => 1 //active
                ],
                [
                    'name' => 'user',
                    'email' => 'user@gmail.com',
                    'phone' => '1234567890',
                    'password' => Hash::make('123456'),
                    'type' => 2, //admin
                    'status' => 1 //active
                ]
            ]
        );
    }
}
