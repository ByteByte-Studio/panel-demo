<?php

namespace App\Filament\Resources\Groups\Tables;

use App\Models\Group;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Grupo')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user-group'),

                TextColumn::make('current_members_count')
                    ->label('Ocupación')
                    ->sortable()
                    ->formatStateUsing(fn ($state, Group $record) => "{$state} / {$record->capacity}")
                    ->badge()
                    ->color(fn ($state, Group $record) => match (true) {
                        $state >= $record->capacity => 'danger',
                        $state >= ($record->capacity * 0.8) => 'warning',
                        default => 'success',
                    })
                    ->icon(fn ($state, Group $record) => $state >= $record->capacity ? 'heroicon-m-lock-closed' : 'heroicon-m-lock-open'),

                TextColumn::make('date_time')
                    ->label('Fecha de Entrevista')
                    ->dateTime('l d M, Y - h:i A')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days')
                    ->description(fn (Group $record) => ucfirst($record->date_time->locale('es')->diffForHumans())),

                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->onColor('success')
                    ->offColor('danger'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Creado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Actualizado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
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
