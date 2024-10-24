<?php

namespace Database\Factories;

use App\Models\Frequency;
use Carbon\WeekDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkSchedule>
 */
class WorkScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shift_start_time' => $this->faker->time(),
            'shift_end_time' => $this->faker->time(),
            'frequency' => $this->faker->randomElement(Frequency::cases()),
            'days_of_week' => $this->faker->randomElement(WeekDay::cases()),
            'doctor_id' => null,
        ];
    }
}
