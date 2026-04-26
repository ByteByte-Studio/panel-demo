<?php

namespace App\Filament\Resources\Clients\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight; // Necesario para el peso de la fuente

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Cliente')
                    ->weight(FontWeight::Medium)
                    ->description(fn($record) => $record->occupation ?: $record->rfc)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('person_type')
                    ->label('Régimen')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'persona_fisica' => 'heroicon-m-user',
                        'persona_moral' => 'heroicon-m-building-office',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color('primary')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'persona_fisica' => 'Física',
                        'persona_moral' => 'Moral',
                        default => $state,
                    })
                    ->width('1%'),

                TextColumn::make('phone_number')
                    ->label('Teléfono')
                    ->icon('heroicon-m-phone')
                    ->color('gray')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('client_type')
                    ->label('Tipo')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'cliente' => 'heroicon-m-user-group',
                        'prospecto' => 'heroicon-m-user-plus',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'cliente' => 'primary',
                        'prospecto' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cliente' => 'Cliente',
                        'prospecto' => 'Prospecto',
                        default => $state,
                    }),

                TextColumn::make('email')
                    ->label('Correo')
                    ->icon('heroicon-m-envelope')
                    ->color('gray')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('rfc')
                    ->label('RFC')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
