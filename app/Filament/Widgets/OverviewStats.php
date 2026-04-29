<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use App\Models\Client;
use App\Models\Conversation;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStats extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $monthlyRevenue = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        return [
            Stat::make('Expedientes Totales', Client::count())
                ->description('Crecimiento del 12%')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Citas Hoy', Appointments::whereDate('date_time', today())->count())
                ->description('3 por atender')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Cobranza del Mes', '$'.number_format($monthlyRevenue, 0))
                ->description('Meta: $50,000')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([1500, 3000, 4500, 10000, 8000, 12000, 15000])
                ->color('primary'),

            Stat::make('Conversaciones Activas', Conversation::count())
                ->description('Automatización en curso')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
        ];
    }
}
