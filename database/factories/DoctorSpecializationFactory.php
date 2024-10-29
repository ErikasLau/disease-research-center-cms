<?php

namespace Database\Factories;

use App\Models\DoctorSpecialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorSpecialization>
 */
class DoctorSpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->text,
        ];
    }
}
