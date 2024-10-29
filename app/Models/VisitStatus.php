<?php

namespace App\Models;

enum VisitStatus: int
{
    case CREATED = 0;
    case COMPLETED = 1;
    case NO_SHOW = 2;
    case CANCELED = 3;

    public static function getOptions(): array
    {
        return array_map(fn(VisitStatus $case) => $case->value, VisitStatus::cases());
    }
}
