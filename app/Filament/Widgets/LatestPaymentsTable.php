<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Number;

class LatestPaymentsTable extends BaseWidget
{
    protected static ?int $sort = 12;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Últimos Pagos Recibidos';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('paymentable.full_name')
                    ->label('Cliente')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('concept')
                    ->label('Concepto')
                    ->limit(30),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto')
                    ->formatStateUsing(fn ($state) => Number::currency($state, 'MXN'))
                    ->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn ($state) => $state === 'completed' ? 'success' : 'warning'),
            ]);
    }
}
