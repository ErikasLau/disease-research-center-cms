<?php

namespace Database\Factories;

use App\Models\doctorAppointmentSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<doctorAppointmentSlot>
 */
class DoctorAppointmentSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = date('Y-m-d H:i', $this->faker->dateTimeBetween('-1 week', '+1 week'));
        $endTime = date('Y-m-d H:i', strtotime('+30 minutes', $startTime));

        return [
            //
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_available' => $this->faker->boolean(),
            'doctor_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
