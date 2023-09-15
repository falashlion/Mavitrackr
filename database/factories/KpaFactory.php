<?php

namespace Database\Factories;

use App\Models\Kpa;
use Illuminate\Database\Eloquent\Factories\Factory;

class KpaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kpa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'strategic_domains_id' => function () {
                return \App\Models\StrategicDomain::factory()->create()->id;
            },
        ];
    }
}
