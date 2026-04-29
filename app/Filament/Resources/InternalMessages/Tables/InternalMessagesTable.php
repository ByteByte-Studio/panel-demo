<?php

namespace App\Filament\Resources\InternalMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('sender.name')
                    ->label('De')
                    ->icon('heroicon-m-user-circle')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('subject')
                    ->label('Asunto')
                    ->weight('medium')
                    ->searchable()
                    ->description(fn ($record) => str($record->body)->stripTags()->limit(50)),

                TextColumn::make('created_at')
                    ->label('Recibido')
                    ->since()
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $isAttended = $record->recipients()
                            ->where('user_id', auth()->id())
                            ->whereNotNull('attended_at')
                            ->exists();

                        return $isAttended ? 'Leído' : 'Nuevo';
                    })
                    ->colors([
                        'success' => 'Leído',
                        'primary' => 'Nuevo',
                    ])
                    ->icons([
                        'heroicon-m-check-circle' => 'Leído',
                        'heroicon-m-envelope' => 'Nuevo',
                    ]),
            ])
            ->recordActions([
                Action::make('attend')
                    ->label('Marcar Leído')
                    ->icon('heroicon-m-check')
                    ->color('primary')
                    ->visible(
                        fn ($record) => $record->recipients()
                            ->where('users.id', auth()->id())
                            ->wherePivotNull('attended_at')
                            ->exists()
                    )
                    ->action(
                        fn ($record) => $record->recipients()
                            ->updateExistingPivot(auth()->id(), [
                                'attended_at' => now(),
                            ])
                    ),

                ViewAction::make()
                    ->modalHeading('Leer Mensaje')
                    ->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
