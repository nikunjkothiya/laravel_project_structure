<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Monster;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database
     *
     * @return void
     * 
     */
    public function run()
    {
        Monster::factory(5)->create();
    }
}