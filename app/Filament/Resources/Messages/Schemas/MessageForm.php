<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Conversación')
                    ->description('Conversación a la que pertenece este mensaje.')
                    ->icon('heroicon-m-link')
                    ->columns(2)
                    ->schema([
                        Select::make('conversation_id')
                            ->relationship('conversation', 'chat_id')
                            ->label('Número de Telefono')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled()
                            ->prefixIcon('heroicon-m-chat-bubble-oval-left-ellipsis'),

                        Select::make('role')
                            ->label('Rol')
                            ->options([
                                'user' => 'Usuario',
                                'assistant' => 'Bot',
                            ])
                            ->required()
                            ->native(false)
                            ->disabled()
                            ->prefixIcon('heroicon-m-user'),
                    ]),

                Section::make('Contenido')
                    ->schema([
                        Textarea::make('message')
                            ->label('Texto del Mensaje')
                            ->required()
                            ->rows(5)
                            ->autosize()
                            ->disabled()
                            ->columnSpanFull(),

                        ViewField::make('preview')
                            ->label('Vista Previa (Estilo Chat)')
                            ->view('filament.resources.conversations.components.message-preview')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
