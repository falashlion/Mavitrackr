<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use HasUuids;
    public function run()
    {
     Department::create(['title' => 'Finance']);
     Department::create(['title' => 'IT']);
     Department::create(['title' => 'Business']);
     Department::create(['title' => 'Operations']);
     Department::create(['title' => 'Sales']);
     Department::create(['title' => 'Administration']);
     Department::create(['title' => 'Support-Staff']);
    }
}
