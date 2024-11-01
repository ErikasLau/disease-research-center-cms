<?php

namespace Database\Factories;

use App\Models\Frequency;
use App\Models\WorkSchedule;
use Carbon\WeekDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkSchedule>
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
            'shift_start_date' => $this->faker->date(),
            'shift_end_date' => $this->faker->date(),
            'days_of_week' => $this->faker->randomElement(WeekDay::cases()),
            'doctor_id' => null,
        ];
    }
}
