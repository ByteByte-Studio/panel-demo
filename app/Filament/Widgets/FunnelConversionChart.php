<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Stage;
use Filament\Widgets\ChartWidget;

class FunnelConversionChart extends ChartWidget
{
    protected ?string $heading = 'Embudo de Conversión (Fases)';

    protected static ?int $sort = 8;

    protected function getData(): array
    {
        // This is a simulation since we don't have a direct stage_id on Client in the schema I saw
        // but we can count responses per stage if they were linked, or just use random data for the demo
        // Let's use the Stages names as labels
        $stages = Stage::orderBy('order')->pluck('name')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Expedientes',
                    'data' => [45, 32, 21, 15, 8], // Demo data for funnel visualization
                    'backgroundColor' => [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(244, 63, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                    ],
                ],
            ],
            'labels' => $stages ?: ['Registro', 'Validación', 'Entrevista', 'Evaluación', 'Cierre'],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
