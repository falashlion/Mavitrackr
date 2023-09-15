<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use HasUuids;
    public function run()
    {
        Position::create(['title' => 'Admin']);
        Position::create(['title' => 'Sales Representative']);
        Position::create(['title' => 'CEO']);
        Position::create(['title' => 'Head of Finance']);
        Position::create(['title' => 'Head of Operations']);
        Position::create(['title' => 'Head of Business']);
        Position::create(['title' => 'Product Owner']);
        Position::create(['title' => 'Frontend Team-Lead']);
        Position::create(['title' => 'Head of Human Resources']);
        Position::create(['title' => 'Office assistant']);
        Position::create(['title' => 'Backend Team-Lead']);
    }
}
