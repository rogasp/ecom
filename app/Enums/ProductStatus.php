<?php

namespace App\Enums;

enum ProductStatus: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case HIDDEN = 'hidden';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, ProductStatus::cases());
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => ucfirst(strtolower($case->name))])->all();
    }
}
