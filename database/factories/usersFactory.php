<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\users>
 */
class usersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {



        return [
          'first_name'=> $this->faker->name(),
          'last_name'=> $this->faker->name(),
          'address'=> $this->faker->streetAddress(),
          'email' =>  $this->faker->safeEmail(),
          'phone_number' => $this->faker-> phoneNumber(),
          'date_of_birth'=> $this->faker-> dateTimeThisDecade(),
            'password' => $this->faker-> password(),



        ];

    }
}
