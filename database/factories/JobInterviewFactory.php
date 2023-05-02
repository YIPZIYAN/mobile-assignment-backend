<?php

namespace Database\Factories;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobInterview>
 */
class JobInterviewFactory extends Factory
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
        $startTime = fake()->time();
        $endTime = fake()->time();
        if($endTime <= $startTime){
            $endTime = fake()->dateTimeBetween($startTime, '+1 day');
        }  
        if ($type != 'virtual') {
            $location = fake()->address();
        }else{
            $location = null;
        }
        return [
            'user_id' => User::all()->random()->id,
            'job_post_id' => JobPost::all()->random()->id,
            'date' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'type' => $type,
            'link' => fake()->url(),
            'location' => $location,
            'description' => fake()->paragraph(),
        ];
    }
}
