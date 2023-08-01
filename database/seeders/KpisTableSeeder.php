<?php

namespace Database\Seeders;

use App\Models\Kpi;
use Illuminate\Database\Seeder;

class KpisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Kpi::factory()->count(100)->create();
    }
}
