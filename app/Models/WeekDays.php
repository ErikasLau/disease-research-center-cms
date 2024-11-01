<?php

namespace App\Models;

enum WeekDays: int
{
    case MONDAY = 0;
    case TUESDAY = 1;
    case WEDNESDAY = 2;
    case THURSDAY = 3;
    case FRIDAY = 4;
    case SUNDAY = 5;
    case SATURDAY = 6;

    public static function getOptions(): array
    {
        return array_map(fn(WeekDays $case) => $case->value, WeekDays::cases());
    }

    public static function values(): array
    {
        $translations = [
            'MONDAY' => 'Pirmadienis',
            'TUESDAY' => 'Antradienis',
            'WEDNESDAY' => 'Trečiadienis',
            'THURSDAY' => 'Ketvirtadienis',
            'FRIDAY' => 'Penktadienis',
            'SUNDAY' => 'Šeštadienis',
            'SATURDAY' => 'Sekmadienis'
        ];

        return array_map(fn(WeekDays $case) => [
            'name' => $translations[$case->name],
            'value' => $case->value,
        ], WeekDays::cases());
    }
}
