<?php

declare(strict_types=1);

namespace App\Enums;

enum Timezones: string
{
    case CET = 'CET';
    case CST = 'CST';
    case GMT1 = 'GMT+1';

    public static function values(): array
    {
        return [
            self::CET->value,
            self::CST->value,
            self::GMT1->value,
        ];
    }
}
