<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' =>$this->faker->uuid,
            'user_matricule' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'password' => $this->faker->password, // Change this if you have specific password requirements
            'profile_image' => null, // Set a default value for profile_image if needed
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'line_manager'=> function () {
                return \App\Models\User::factory()->create()->id;
            },
            'departments_id' =>function () {
                return \App\Models\Department::factory()->create()->id;
            },// Set appropriate values for foreign keys
            'positions_id' =>function () {
                return \App\Models\Position::factory()->create()->id;
            }, // Set appropriate values for foreign keys
            'roles' => $this->faker->randomElement(['Admin','Employee','Manager']),
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
