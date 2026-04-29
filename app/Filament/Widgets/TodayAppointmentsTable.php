<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TodayAppointmentsTable extends BaseWidget
{
    protected static ?int $sort = 10;

    protected int|string|array $columnSpan = 1;

    protected static ?string $heading = 'Citas para Hoy';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointments::whereDate('date_time', today())
                    ->orderBy('date_time', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('date_time')
                    ->label('Hora')
                    ->time('h:i A')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('appointmentable.full_name')
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidad')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn ($state) => $state->color()),
            ])
            ->paginated(false);
    }
}
