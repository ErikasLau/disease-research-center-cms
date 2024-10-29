<?php

namespace App\Models;

enum Role: int
{
    case ADMIN = 0;
    case PATIENT = 1;
    case DOCTOR = 2;
    case LABORATORIAN = 3;

    public static function getOptions(): array
    {
        return array_map(fn(Role $case) => $case->value, Role::cases());
    }
}
