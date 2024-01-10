<?php

namespace Database\Seeders;

use App\Models\Kpa;
use App\Models\StrategicDomain;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;

class KpasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // use HasUuids;
    public function run()
    {
     $strategicDomains = StrategicDomain::OrderBy('id')->get();

    $titles = ['Event Organization','Onboarding and Integration','Recruitment','Learning & Development'];
    $i = 0;
    foreach ($strategicDomains as $domain) {

        // var_dump($i.'-'.$domain->id,);
        $kpa = Kpa::create([
            'strategic_domain_id' =>$domain->id,
            'title' => $titles[$i++],
        ]);
        $kpa->save();
    }
}
}
