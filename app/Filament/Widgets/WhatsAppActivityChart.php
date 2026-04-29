<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WhatsAppActivityChart extends ChartWidget
{
    protected ?string $heading = 'Actividad de WhatsApp (7 días)';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $sent = Trend::query(Message::where('role', 'assistant'))
            ->between(start: now()->subDays(7), end: now())
            ->perDay()
            ->count();

        $received = Trend::query(Message::where('role', 'user'))
            ->between(start: now()->subDays(7), end: now())
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mensajes Enviados (Bot)',
                    'data' => $sent->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#6233a4',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Mensajes Recibidos (Usuarios)',
                    'data' => $received->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#9063cf',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $sent->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
