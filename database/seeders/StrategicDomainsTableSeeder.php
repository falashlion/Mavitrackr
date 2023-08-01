<?php

namespace Database\Seeders;

use App\Models\StrategicDomain;
use Illuminate\Database\Seeder;

class StrategicDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        StrategicDomain::factory()->count(10)->create();
    }
}
