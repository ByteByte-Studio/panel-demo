<?php

namespace App\Enums;

enum PaymentNotificationStatus: string
{
    case NotReminded = 'not_reminded';
    case EarlyReminder = 'early_reminder';
    case Reminder = 'reminder';
    case LateReminder = 'late_reminder';
    case Disabled = 'disabled';

    /**
     * Label legible para UI
     */
    public function label(): string
    {
        return match ($this) {
            self::NotReminded => 'Sin notificar',
            self::EarlyReminder => 'Recordatorio previo',
            self::Reminder => 'Día de pago',
            self::LateReminder => 'Recordatorio de atraso',
            self::Disabled => 'Deshabilitado',
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
            self::NotReminded => 'gray',
            self::EarlyReminder => 'info',
            self::Reminder => 'warning',
            self::LateReminder => 'danger',
            self::Disabled => 'gray',
        };
    }
}
