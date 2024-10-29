<?php

namespace Database\Factories;

use App\Models\Examination;
use App\Models\ExaminationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Examination>
 */
class ExaminationFactory extends Factory
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
            'type' => $this->faker->word(),
            'status' => array_rand(ExaminationStatus::getOptions()),
            'comment' => $this->faker->text(),
            'patient_id' => $this->faker->numberBetween(1, 10),
            'result_id' => null,
        ];
    }
}
