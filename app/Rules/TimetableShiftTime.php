<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TimetableShiftTime implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $timetable) {
            $startTime = strtotime($timetable['shift_start_time']);
            $endTime = strtotime($timetable['shift_end_time']);

            $startDate = strtotime($timetable['job_start_date']);
            $endDate = strtotime($timetable['job_end_date']);

            if ($endTime <= $startTime) {
                $fail('Jūsų įvestas darbo laiko intervalas yra neteisingas. Prašome patikrinti, ar pradžios laikas yra ankstesnis už pabaigos laiką.');
            }

            if ($endDate <= $startDate) {
                $fail('Jūsų įvestas darbo laiko intervalas yra neteisingas. Prašome patikrinti, ar pradžios data yra ankstesnė už pabaigos datą.');
            }
        }
    }
}
