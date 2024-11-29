<?php

namespace Tests\Unit;

use App\Models\DoctorAppointmentSlot;
use App\Models\WeekDays;
use App\Models\WorkSchedule;
use App\Services\ScheduleService;
use Carbon\Carbon;
use DateTime;
use PHPUnit\Framework\TestCase;

class ScheduleServiceTest extends TestCase
{
    /**
     * Test basic functionality of converting work schedule to appointments
     */
    public function test_convert_work_schedule_to_appointments()
    {
        $now = new DateTime();
        $next = new DateTime();
        $next->modify('+7 day');

        $shiftStartTime = '09:00';
        $shiftEndTime = '17:00';

        // Mock a WorkSchedule model
        $workSchedule = new WorkSchedule([
            'shift_start_date' => $now->format('Y-m-d'),
            'shift_end_date' => $next->format('Y-m-d'),
            'shift_start_time' => $shiftStartTime,
            'shift_end_time' => $shiftEndTime,
            'days_of_week' => WeekDays::FRIDAY->name,
        ]);

        $appointments = (new ScheduleService)->convertWorkScheduleToAppointments($workSchedule, '1');

        $slotCount = floor(abs(Carbon::parse($shiftEndTime)->diffInMinutes(Carbon::parse($shiftStartTime))) / 30);

        // Assertions
        $this->assertCount($slotCount, $appointments);

        foreach ($appointments as $appointment) {
            $this->assertInstanceOf(DoctorAppointmentSlot::class, $appointment);
            $this->assertTrue($appointment->is_available);
            $this->assertEquals('1', $appointment->doctor_id);

            $startTime = Carbon::parse($appointment->start_time);
            $endTime = Carbon::parse($appointment->end_time);

            $this->assertTrue($startTime->between(Carbon::parse($now->format('Y-m-d') . ' ' . $shiftStartTime), Carbon::parse($next->format('Y-m-d') . ' ' . $shiftEndTime)));
            $this->assertEquals(30, abs($startTime->diffInMinutes($endTime)));
        }

        $this->assertStringContainsString($shiftStartTime, $appointments[0]->start_time);
        $this->assertStringContainsString($shiftEndTime, end($appointments)->end_time);
    }

    /**
     * Test if no appointments are created when selected dates have passed
     */
    public function test_when_time_has_passed_no_appointments_created()
    {
        $now = new DateTime();
        $next = new DateTime();
        $now->modify('-7 day');
        $next->modify('-1 day');

        $shiftStartTime = '09:00';
        $shiftEndTime = '17:00';

        // Mock a WorkSchedule model
        $workSchedule = new WorkSchedule([
            'shift_start_date' => $now->format('Y-m-d'),
            'shift_end_date' => $next->format('Y-m-d'),
            'shift_start_time' => $shiftStartTime,
            'shift_end_time' => $shiftEndTime,
            'days_of_week' => WeekDays::FRIDAY->name,
        ]);

        $appointments = (new ScheduleService)->convertWorkScheduleToAppointments($workSchedule, '1');

        $this->assertCount(0, $appointments);
    }

    /**
     * Test if x2 slots are created when date interval is two weeks
     */
    public function test_when_more_than_one_week_selected_appointment_count_multiplies()
    {
        $now = new DateTime();
        $next = new DateTime();
        $next->modify('+14 day');

        $shiftStartTime = '09:00';
        $shiftEndTime = '17:00';

        // Mock a WorkSchedule model
        $workSchedule = new WorkSchedule([
            'shift_start_date' => $now->format('Y-m-d'),
            'shift_end_date' => $next->format('Y-m-d'),
            'shift_start_time' => $shiftStartTime,
            'shift_end_time' => $shiftEndTime,
            'days_of_week' => WeekDays::FRIDAY->name,
        ]);

        $appointments = (new ScheduleService)->convertWorkScheduleToAppointments($workSchedule, '1');
        $slotCount = floor(abs(Carbon::parse($shiftEndTime)->diffInMinutes(Carbon::parse($shiftStartTime))) / 30);

        $this->assertCount($slotCount * 2, $appointments);
    }
}
