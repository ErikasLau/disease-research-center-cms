<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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
            'text' => $this->faker->realText(),
            'result_id' => $this->faker->numberBetween(1, 10),
            'doctor_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
