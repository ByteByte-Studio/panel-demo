<?php

namespace App\Filament\Widgets;

use App\Models\InternalAnnouncement;
use App\Models\InternalMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InternalMessagesSummary extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Mensajes Internos', InternalMessage::count())
                ->description('Conversaciones del equipo')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
                ->color('gray'),

            Stat::make('Por Leer', InternalMessage::whereHas('recipients', function ($q) {
                $q->where('user_id', auth()->id())->whereNull('attended_at');
            })->count())
                ->description('Pendientes de atención')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),

            Stat::make('Anuncios Recientes', InternalAnnouncement::where('created_at', '>=', now()->subDays(7))->count())
                ->description('Últimos 7 días')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),
        ];
    }
}
