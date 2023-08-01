<?php

namespace Database\Factories;

use App\Models\StrategicDomain;
use Illuminate\Database\Eloquent\Factories\Factory;

class StrategicDomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StrategicDomain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['Financial', 'Customer', 'Process', 'People']),
        ];
    }
}
