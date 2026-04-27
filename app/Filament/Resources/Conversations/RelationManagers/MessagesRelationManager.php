<?php

namespace App\Filament\Resources\Conversations\RelationManagers;

use App\Models\Message;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ViewField;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $recordTitleAttribute = 'message';

    protected static ?string $title = 'Historial de Mensajes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                ViewField::make('preview')
                    ->label('Mensaje')
                    ->view('filament.resources.conversations.components.message-preview')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->defaultSort('created_at', 'asc')
            ->columns([
                IconColumn::make('role')
                    ->label('Rol')
                    ->icon(fn(string $state): string => match ($state) {
                        'user' => 'heroicon-m-user',
                        'assistant' => 'heroicon-m-cpu-chip',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'user' => 'success',
                        'assistant' => 'info',
                        default => 'gray',
                    })
                    ->tooltip(fn(string $state): string => match ($state) {
                        'user' => 'Mensaje Entrante (Usuario)',
                        'assistant' => 'Mensaje Saliente (Bot)',
                        default => $state,
                    }),

                TextColumn::make('message')
                    ->label('Mensaje')
                    ->wrap()
                    ->grow()
                    ->color(fn(Message $record) => $record->role === 'assistant' ? 'gray' : 'black')
                    ->description(fn(Message $record) => $record->created_at->locale('es')->diffForHumans(), position: 'below'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filtrar por Emisor')
                    ->options([
                        'user' => 'Usuario',
                        'assistant' => 'Bot',
                    ]),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->modalHeading('Contenido Completo del Mensaje'),
                ])
                    ->color('gray'),
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateHeading('Sin mensajes registrados en esta conversación')
            ->emptyStateDescription('El historial aparecerá aquí conforme el usuario y el bot interactúen.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-ellipsis');
    }
}
