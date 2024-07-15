<?php

namespace App\Enums;

enum ProductType: string
{
    case PHYSICAL = 'physical';
    case DIGITAL = 'digital';
    case SERVICE = 'service';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, ProductType::cases());
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => ucfirst(strtolower($case->name))])->all();
    }
}
