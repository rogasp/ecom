<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';     // Ordern har mottagits men väntar på betalning eller bekräftelse
    case PROCESSING = 'processing'; // Betalning har mottagits och ordern behandlas
    case SHIPPED = 'shipped';     // Ordern har skickats
    case DELIVERED = 'delivered';   // Ordern har levererats
    case CANCELLED = 'cancelled';   // Ordern har avbrutits av kunden eller administratören
    case REFUNDED = 'refunded';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, OrderStatus::cases());
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => ucfirst(strtolower($case->name))])->all();
    }
}
