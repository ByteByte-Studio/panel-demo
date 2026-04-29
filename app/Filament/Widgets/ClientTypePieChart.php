<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;

class ClientTypePieChart extends ChartWidget
{
    protected ?string $heading = 'Naturaleza Jurídica de Expedientes';

    protected static ?int $sort = 9;

    protected function getData(): array
    {
        $fisica = Client::where('person_type', 'persona_fisica')->count();
        $moral = Client::where('person_type', 'persona_moral')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Expedientes',
                    'data' => [$fisica, $moral],
                    'backgroundColor' => ['#6233a4', '#9063cf'],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Persona Física', 'Persona Moral'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
