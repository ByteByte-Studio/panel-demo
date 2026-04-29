<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información Personal')
                    ->description('Datos básicos y de contacto.')
                    ->icon('heroicon-m-user-circle')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nombre Completo')
                                ->required()
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-user'),

                            TextInput::make('email')
                                ->label('Correo Electrónico')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-at-symbol'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('phone_number')
                                ->label('Teléfono Celular')
                                ->tel()
                                ->maxLength(20)
                                ->prefixIcon('heroicon-m-phone'),

                            TextInput::make('whatsapp_number')
                                ->label('Número de WhatsApp (Notificaciones)')
                                ->tel()
                                ->maxLength(20)
                                ->prefixIcon('heroicon-m-chat-bubble-left-right'),
                        ]),

                        FileUpload::make('avatar_url')
                            ->label('Imagen de Perfil')
                            ->image()
                            ->avatar()
                            ->directory('avatars'),

                        Textarea::make('bio')
                            ->label('Biografía')
                            ->rows(3)
                            ->maxLength(500),
                    ]),

                Section::make('Seguridad')
                    ->icon('heroicon-m-shield-check')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('password')
                                ->label('Contraseña')
                                ->password()
                                ->revealable()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-key'),

                            TextInput::make('password_confirmation')
                                ->label('Confirmar Contraseña')
                                ->password()
                                ->revealable()
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->same('password')
                                ->dehydrated(false)
                                ->prefixIcon('heroicon-m-check-circle'),
                        ]),
                    ]),
            ]);
    }
}
