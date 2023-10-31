<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([StrategicDomainsTableSeeder::class]);
        $this->call([DepartmentsTableSeeder::class]);
        $this->call([KpasTableSeeder::class]);
        $this->call([PositionsTableSeeder::class]);
        $this->call([RolesPermissionsSeeder::class]);

    }
}
