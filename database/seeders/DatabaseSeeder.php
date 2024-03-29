<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(UserTableSeeder::class);
        $this->call(InterestTableSeeder::class);
        $this->call(PostTableSeeder::class);
        //$this->call(ProfilePictureTableSeeder::class);
        $this->call(DescriptionTableSeeder::class);



    }
}
