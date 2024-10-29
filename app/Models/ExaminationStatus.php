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
        return array_map(fn(ExaminationStatus $case) => $case->value, ExaminationStatus::cases());
    }
}
