<?php

namespace App\Filament\Resources\Conversations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConversationsTable
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
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->user_name ?? 'U').'&color=FFFFFF&background=111827')
                    ->grow(false),

                TextColumn::make('user_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $formatPhone($record->chat_id)),

                TextColumn::make('latestMessage.message')
                    ->label('Última interacción')
                    ->limit(60)
                    ->color('gray')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->iconColor('gray')
                    ->wrap()
                    ->placeholder('Sin mensajes registrados'),

                TextColumn::make('updated_at')
                    ->label('Actividad')
                    ->since()
                    ->sortable()
                    ->alignEnd()
                    ->color('primary')
                    ->size('sm'),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
