<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Sum;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d M Y')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('client.full_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd()
                    ->summarize(Sum::make()->label('Total')->money('MXN')),

                TextColumn::make('payment_method')
                    ->label('Método')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Efectivo' => 'heroicon-m-banknotes',
                        'Transferencia' => 'heroicon-m-arrows-right-left',
                        default => 'heroicon-m-credit-card',
                    })
                    ->colors([
                        'success' => 'Efectivo',
                        'info' => 'Transferencia',
                        'primary' => 'Tarjeta de Crédito/Débito',
                        'warning' => 'Cheque',
                    ]),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->limit(30)
                    ->searchable()
                    ->tooltip(fn($record) => $record->concept),

                TextColumn::make('transaction_reference')
                    ->label('Ref.')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('payment_metod')
                    ->label('Método de Pago')
                    ->options([
                        'Efectivo' => 'Efectivo',
                        'Transferencia' => 'Transferencia',
                        'Tarjeta de Crédito/Débito' => 'Tarjeta',
                        'Cheque' => 'Cheque',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
