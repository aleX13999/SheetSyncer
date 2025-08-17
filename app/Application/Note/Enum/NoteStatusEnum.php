<?php

namespace App\Application\Note\Enum;

enum NoteStatusEnum: string
{
    case ALLOWED    = 'Allowed';
    case PROHIBITED = 'Prohibited';

    public static function getValues(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
