<?php

namespace App\Models;

enum Frequency: int
{
    case DAILY = 0;
    case WEEKLY = 1;
    case MONTHLY = 2;

    public static function getOptions(): array
    {
        return array_map(fn(Frequency $case) => $case->value, Frequency::cases());
    }
}
