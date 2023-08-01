<?php

namespace Database\Seeders;

use App\Models\Kpa;
use Illuminate\Database\Seeder;

class KpasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Kpa::factory()->count(50)->create();
    }
}
