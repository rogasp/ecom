<?php

namespace App\Enums;

enum OrderItemStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';
    case REFUNDED = 'refunded';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, OrderItemStatus::cases());
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => ucfirst(strtolower($case->name))])->all();
    }
}
