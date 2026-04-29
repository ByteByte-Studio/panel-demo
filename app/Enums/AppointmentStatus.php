<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case RescheduleProposed = 'reschedule_proposed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case NoShow = 'no_show';

    /**
     * Label legible para UI
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Confirmed => 'Confirmada',
            self::RescheduleProposed => 'Reprogramación propuesta',
            self::Rejected => 'Rechazada',
            self::Cancelled => 'Cancelada',
            self::Completed => 'Completada',
            self::NoShow => 'No asistió',
        };
    }

    /**
     * Array para dropdowns
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [
                $case->value => $case->label(),
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
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::RescheduleProposed => 'info',
            self::Rejected => 'danger',
            self::Cancelled => 'gray',
            self::Completed => 'success',
            self::NoShow => 'danger',
        };
    }
}
