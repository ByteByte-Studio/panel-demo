<?php

namespace App\Filament\Resources\InternalAnnouncements\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InternalAnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Título')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            RichEditor::make('body')
                ->label('Contenido')
                ->required()
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'min-h-[30rem]',
                ]),

            Toggle::make('notify_whatsapp')
                ->label('Notificar por WhatsApp')
                ->helperText('Enviar este anuncio por WhatsApp a todos los usuarios')
                ->default(false)
                ->dehydrated(false)
                ->columnSpanFull(),
        ]);
    }
}
