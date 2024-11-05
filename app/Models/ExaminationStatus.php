<?php

namespace App\Models;

enum ExaminationStatus: int
{
    case NOT_COMPLETED = 0;
    case IN_PROGRESS = 1;
    case SENT_TO_CONFIRM = 2;
    case AT_DOCTOR = 3;

    public static function getOptions(): array
    {
        return array_map(fn(ExaminationStatus $case) => $case->name, ExaminationStatus::cases());
    }

    public static function values(): array
    {
        $translations = [
            'NOT_COMPLETED' => 'Neįvykdytas',
            'IN_PROGRESS' => 'Vykdomas',
            'SENT_TO_CONFIRM' => 'Išsiųstas patvirtinti',
            'AT_DOCTOR' => 'Pas gydytoją',
        ];

        return array_map(fn(ExaminationStatus $case) => $translations[$case->name], ExaminationStatus::cases());
    }
}
