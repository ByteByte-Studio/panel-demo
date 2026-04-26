<?php

namespace App\Filament\Resources\InternalMessages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;


class InternalMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Redactar Mensaje')
                    ->columnSpanFull()
                    ->columns(2)
                    ->description('Envía notificaciones o actualizaciones a otros usuarios del sistema.')
                    ->schema([
                        Select::make('recipients')
                            ->label('Destinatarios')
                            ->multiple()
                            ->relationship('recipients', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-users'),

                        TextInput::make('subject')
                            ->label('Asunto')
                            ->required()
                            ->placeholder('Ej. Actualización del Caso #1234')
                            ->prefixIcon('heroicon-m-chat-bubble-left-ellipsis'),

                        RichEditor::make('body')
                            ->label('Mensaje')
                            ->required()
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link', 'attachFiles'])
                            ->placeholder('Escribe aquí el contenido del mensaje...')
                            ->columnSpanFull(),

                        Toggle::make('notify_whatsapp')
                            ->label('Notificar por WhatsApp')
                            ->helperText('Enviar este mensaje también por WhatsApp')
                            ->default(false)
                            ->dehydrated(false)
                    ]),
            ]);
    }
}
