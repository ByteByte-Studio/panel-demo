<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use Filament\Widgets\ChartWidget;

class AppointmentsStatusChart extends ChartWidget
{
    protected ?string $heading = 'Distribución de Citas';

    protected static ?int $sort = 7;

    protected function getData(): array
    {
        $data = Appointments::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count', 'status')
            ->toArray();

        $labels = array_keys($data);
        $values = array_values($data);

        return [
            'datasets' => [
                [
                    'label' => 'Citas',
                    'data' => $values,
                    'backgroundColor' => [
                        '#f59e0b', // pending
                        '#10b981', // confirmed
                        '#6233a4', // reschedule (Primary)
                        '#ef4444', // rejected/cancelled
                        '#9063cf', // completed (Highlight Light)
                    ],
                    'borderWidth' => 0,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => collect($labels)->map(fn ($l) => match ($l) {
                'pending' => 'Pendientes',
                'confirmed' => 'Confirmadas',
                'reschedule_proposed' => 'Reagendamiento',
                'rejected' => 'Rechazadas',
                'cancelled' => 'Canceladas',
                'completed' => 'Completadas',
                'no_show' => 'No asistió',
                default => ucfirst($l),
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
