<?php

namespace Database\Factories;

use App\Models\Frequency;
use App\Models\WeekDays;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Carbon\WeekDay;
use DateTime;
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
        $currDate = new DateTime();
        $shiftStartTime = Carbon::parse($this->faker->time());
        $shiftEndTime = $shiftStartTime->copy()->addHours(7)->lt(Carbon::parse('24:00')) ? $shiftStartTime->copy()->addHours(7)->format('H:i') : '23:59';

        return [
            'shift_start_time' => $shiftStartTime,
            'shift_end_time' => $shiftEndTime,
            'shift_start_date' => $currDate,
            'shift_end_date' => $currDate->modify('+4 weeks')->format('Y-m-d'),
            'days_of_week' => $this->faker->randomElement(WeekDays::getOptions()),
            'doctor_id' => null,
        ];
    }
}
