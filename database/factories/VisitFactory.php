<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\VisitStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visit>
 */
class VisitFactory extends Factory
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
            'visit_date' => $this->faker->dateTime(),
            'status' => array_rand(VisitStatus::getOptions()),
            'doctor_id' => $this->faker->numberBetween(1, 10),
            'patient_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
