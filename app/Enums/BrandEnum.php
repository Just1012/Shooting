<?php

namespace App\Enums;

enum BrandEnum: int
{
    case SECTION_ONE = 1;
    case SECTION_TWO = 2;
    case SECTION_THREE = 3;
    case SECTION_FOUR = 4;

    // Additional helper method to get all values if needed
    public static function getValues(): array
    {
        return [
            self::SECTION_ONE->value,
            self::SECTION_TWO->value,
            self::SECTION_THREE->value,
            self::SECTION_FOUR->value,
        ];
    }
}
