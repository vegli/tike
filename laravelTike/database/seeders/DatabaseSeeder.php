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
        Shoes::truncate();
        User::truncate();
        Brand::truncate();
        Type::truncate();

        $this->call([
            TypeSeeder::class
        ]);

        Ski::factory(10)->create();
    }
}
