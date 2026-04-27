<?php

namespace App\Filament\Resources\Conversations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConversationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Contacto')
                    ->description('Identificación del usuario en el chat.')
                    ->icon('heroicon-m-user-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('user_name')
                            ->label('Nombre')
                            ->prefixIcon('heroicon-m-user')
                            ->maxLength(255),

                        TextInput::make('chat_id')
                            ->label('Número de Telefono')
                            ->required()
                            ->prefixIcon('heroicon-m-phone')
                            ->maxLength(255),
                    ]),
            ]);
    }
}
