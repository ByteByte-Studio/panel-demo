<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Paid = 'paid';
    case Pending = 'pending';
    case Partial = 'partial';
    case Cancelled = 'cancelled';

    /**
     * Label legible para UI
     */
    public function label(): string
    {
        return match ($this) {
            self::Paid => 'Pagado',
            self::Pending => 'Pendiente',
            self::Partial => 'Pago parcial',
            self::Cancelled => 'Cancelado',
        };
    }

    /**
     * Array para dropdowns
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [
                $case->value => $case->label()
            ])
            ->toArray();
    }

    public static function toArray(): array
    {
        return collect(self::cases())
            ->map(fn ($case) => $case->value)
            ->toArray();
    }

    public function color(): string
    {
        return match ($this) {
            self::Paid => 'success',
            self::Pending => 'warning',
            self::Partial => 'info',
            self::Cancelled => 'danger',
        };
    }
}
