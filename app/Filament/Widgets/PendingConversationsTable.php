<?php

namespace App\Filament\Widgets;

use App\Models\Conversation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingConversationsTable extends BaseWidget
{
    protected static ?int $sort = 11;

    protected int|string|array $columnSpan = 2;

    protected static ?string $heading = 'Últimos Chats Activos';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Conversation::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('chat_id')
                    ->label('Contacto')
                    ->formatStateUsing(fn ($state) => '+'.$state),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Nombre')
                    ->placeholder('Usuario Desconocido'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Último Mensaje')
                    ->dateTime('H:i')
                    ->description(fn ($record) => $record->updated_at->diffForHumans()),
                Tables\Columns\IconColumn::make('status')
                    ->label('Bot')
                    ->default('heroicon-m-check-circle')
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
