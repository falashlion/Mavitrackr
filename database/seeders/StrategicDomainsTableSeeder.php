<?php

namespace Database\Seeders;

use App\Models\StrategicDomain;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;

class StrategicDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use HasUuids;
    public function run()
    {
        StrategicDomain::create(['title' => 'Financial']);
        StrategicDomain::create(['title' => 'Customer']);
        StrategicDomain::create(['title' => 'Process']);
        StrategicDomain::create(['title' => 'People']);
    }
}
