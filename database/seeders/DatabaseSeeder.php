<?php

namespace Database\Seeders;

use App\Models\Category;
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
        User::insert(
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

        Category::insert([
            ['name' => 'Cate 1.2', 'price' =>  100, 'description' => 'cate', 'type' => 1, 'status' => 1],
            ['name' => 'Cate 2.2', 'price' =>  200, 'description' => 'cate', 'type' => 2, 'status' => 1],
            ['name' => 'Cate 3.2', 'price' =>  500, 'description' => 'cate', 'type' => 3, 'status' => 1],
            ['name' => 'Cate 1.1', 'price' =>  100, 'description' => 'cate', 'type' => 1, 'status' => 1],
            ['name' => 'Cate 2.1', 'price' =>  200, 'description' => 'cate', 'type' => 2, 'status' => 1],
            ['name' => 'Cate 3.1', 'price' =>  500, 'description' => 'cate', 'type' => 3, 'status' => 1],
        ]);
    }
}
