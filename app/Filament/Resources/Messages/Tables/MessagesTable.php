<?php

namespace App\Filament\Resources\Messages\Tables;

use App\Models\Message;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        $formatPhone = function ($state) {
            if (! $state) {
                return '-';
            }

            // Remove 521 prefix if exists (WhatsApp format)
            $clean = preg_replace('/^521/', '', $state);

            // Format as +52 ### ### ####
            if (strlen($clean) === 10) {
                return '+52 '.substr($clean, 0, 3).' '.substr($clean, 3, 3).' '.substr($clean, 6);
            }

            return $state;
        };

        return $table
            ->defaultPaginationPageOption(25)
            ->paginated([25, 50, 100])
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('role')
                    ->label('Rol')
                    ->icon(fn (string $state): string => match ($state) {
                        'user' => 'heroicon-m-user',
                        'assistant' => 'heroicon-m-cpu-chip',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'success',
                        'assistant' => 'info',
                        default => 'gray',
                    })
                    ->tooltip(fn (string $state): string => match ($state) {
                        'user' => 'Mensaje Entrante (Usuario)',
                        'assistant' => 'Mensaje Saliente (Bot)',
                        default => $state,
                    }),

                TextColumn::make('conversation.user_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('conversation.chat_id')
                    ->label('Número de Telefono')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->formatStateUsing($formatPhone)
                    ->url(fn ($state) => 'https://wa.me/'.$state)
                    ->openUrlInNewTab()
                    ->searchable(),

                TextColumn::make('message')
                    ->label('Contenido')
                    ->limit(60)
                    ->tooltip(fn (Message $record) => $record->message)
                    ->searchable()
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->since()
                    ->color('gray')
                    ->icon('heroicon-m-clock')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filtrar por Rol')
                    ->options([
                        'user' => 'Entrantes (Usuarios)',
                        'assistant' => 'Salientes (Bot)',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
