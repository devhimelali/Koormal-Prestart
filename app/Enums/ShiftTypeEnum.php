<?php

namespace App\Enums;

enum ShiftTypeEnum: string
{
    case DAY = 'day';
    case NIGHT = 'night';

    public function label(): string
    {
        return match ($this) {
            self::DAY => 'Day',
            self::NIGHT => 'Night',
        };
    }
}
