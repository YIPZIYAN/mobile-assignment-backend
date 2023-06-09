<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'reg_no' => fake()->numerify('############'),
            'location' => fake()->address(),
        ];
    }
}
