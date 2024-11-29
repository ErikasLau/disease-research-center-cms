<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Timetable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $index => $shift) {
            $startTime = strtotime($shift['shift_start_time']);
            $endTime = strtotime($shift['shift_end_time']);

            foreach ($value as $compareIndex => $compareShift) {
                if ($index === $compareIndex) {
                    continue;
                }

                $compareStartTime = strtotime($compareShift['shift_start_time']);
                $compareEndTime = strtotime($compareShift['shift_end_time']);

                // Check if the shifts overlap on the same week days
                $overlappingDays = array_intersect($shift['week_days'], $compareShift['week_days']);
                if (count($overlappingDays) > 0) {
                    if (($startTime <= $compareStartTime && $endTime > $compareStartTime) ||
                        ($startTime < $compareEndTime && $endTime >= $compareEndTime)) {
                        $fail('Numatyti darbo laikai negali persidengti. Pašalinkite netinkamus variantus.');
                    }
                }
            }
        }
    }
}
