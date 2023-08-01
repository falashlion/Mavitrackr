<?php

namespace Database\Factories;

use App\Models\Kpi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KpiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kpi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'kpas_id' => function () {
                return \App\Models\Kpa::factory()->create()->id;
            },
            'users_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            //'indicators' => $this->faker->sentence,
            'weight' => $this->faker->randomFloat(2, 0, 1),
            'weighted_average_score' => $this->faker->numberBetween(0, 100),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
