<?php

namespace App\Filament\Resources\Stages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->paginated([25, 50, 100])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('name')
                    ->label('Nombre de la Etapa')
                    ->searchable(),

                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Preguntas')
                    ->badge()
                    ->color(fn (string $state): string => $state > 0 ? 'primary' : 'gray'),
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
