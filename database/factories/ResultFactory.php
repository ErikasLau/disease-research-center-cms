<?php

namespace Database\Factories;

use App\Models\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'excerpt' => $this->faker->sentence(),
            'user_id' => $this->faker->numberBetween(1, 10),
            'examination_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
