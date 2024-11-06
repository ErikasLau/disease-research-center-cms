<?php

namespace App\Services;

use App\Models\DoctorAppointmentSlot;
use App\Models\WorkSchedule;
use DateInterval;
use DatePeriod;
use DateTime;

class ScheduleService
{
    private int $slot_time = 1800;

    private static function getDaysInInterval($startDate, $endDate, $weekday): array
    {
        $weekday = strtolower($weekday);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);

        $days = [];
        foreach ($period as $dt) {
            if ($dt->format('l') == ucfirst($weekday)) {
                $days[] = $dt->format('Y-m-d');
            }
        }

        return $days;
    }

    private function createSlots($start_time, $end_time)
    {
        $start_timestamp = strtotime($start_time);
        $end_timestamp = strtotime($end_time);

        $slots = [];
        $current_time = $start_timestamp;

        while ($current_time <= $end_timestamp) {
            $end_slot = $current_time + $this->slot_time; // 1800 seconds = 30 minutes
            $slots[] = [
                'start' => date('H:i', $current_time),
                'end' => date('H:i', $end_slot)
            ];
            $current_time = $end_slot;
        }

        return $slots;
    }


    public function convertWorkScheduleToAppointments(WorkSchedule $workSchedule, string $doctor_id): array
    {
        $results = [];

        //CHECK CURRENT TIME
        $shift_start_date = $workSchedule->shift_start_date;
        $shift_end_date = $workSchedule->shift_end_date;

        $shift_start_time = $workSchedule->shift_start_time;
        $shift_end_time = $workSchedule->shift_end_time;

        $currentTime = strtotime('now');

        if ($shift_end_date < date('Y-m-d', $currentTime) || ($shift_end_date == $currentTime && $shift_end_time < date('H:i', $currentTime))) {
            return $results;
        }

        $shift_start_date = date('Y-m-d');
        $shift_start_time = date('H:i');

        $now = new DateTime();
        $now->modify('+1 month');
        $maxDate = $now->format('Y-m-d');

        $shift_end_date = min($shift_end_date, $maxDate);


        $workingDays = $this->getDaysInInterval(new DateTime($shift_start_date), new DateTime($shift_end_date), $workSchedule->days_of_week);
        $timeSlots = $this->createSlots($shift_start_time, $shift_end_time);

        foreach ($workingDays as $workingDay) {
            foreach ($timeSlots as $timeSlot) {
                $results[] = new DoctorAppointmentSlot(['start_time' => $workingDay . " " . $timeSlot['start'], 'end_time' => $workingDay . " " . $timeSlot['end'], 'is_available' => false, 'doctor_id' => $doctor_id]);
            }
        }

        return $results;
    }
}
