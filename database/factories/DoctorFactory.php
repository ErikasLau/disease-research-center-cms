<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
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
            'license_number' => str_pad($this->faker->randomNumber(9), 9, 'LM', STR_PAD_LEFT),
            'user_id' => $this->faker->numberBetween(1, 10),
            'doctor_specialization_id' => null,
        ];
    }
}
