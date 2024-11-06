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
        return array_map(fn(VisitStatus $case) => $case->name, VisitStatus::cases());
    }

    public static function values(): array
    {
        return array_map(fn(VisitStatus $case) => __('translations.' . $case->name), VisitStatus::cases());
    }
}
