<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CareerDevelopment>
 */
class CareerDevelopmentFactory extends Factory
{

    private const TYPE = [
        'physical',
        'virtual',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(SELF::TYPE);
        $location = "";
        $link = fake()->url();
        $startDate = fake()->dateTimeBetween('+1 month', '+6 month');
        $endDate = fake()->dateTimeBetween($startDate,'+6 month');
        $startTime = fake()->time();
        $endTime = fake()->time();
        if($endTime <= $startTime && $endDate <= $startDate){
            $endTime = fake()->dateTimeBetween($startTime, '+1 day');
        }        
        if ($type != 'virtual') {
            $location = fake()->address();
            $link = null;
        }
        return [
            'title' => fake()->word,
            'date_start' => $startDate,
            'date_end' => $endDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'type' => $type,
            'link' => $link,
            'location' => $location,
            'description' => fake()->paragraph(),
            'capacity' => fake()->numberBetween(50, 200),
            'company_id'=>Company::all()->random()->id,
        ];
    }
}
