<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                Section::make('Información de Acceso')
                    ->description('Datos personales y credenciales de acceso.')
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
                                ->required()
                                ->maxLength(20)
                                ->prefixIcon('heroicon-m-phone'),

                            Toggle::make('has_wa')
                                ->label('¿Cuenta con WhatsApp?')
                                ->inline(false)
                                ->onIcon('heroicon-m-chat-bubble-left-right')
                                ->offIcon('heroicon-m-x-mark')
                                ->onColor('success')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('password')
                                ->label('Contraseña')
                                ->password()
                                ->revealable()
                                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $operation): bool => $operation === 'create')
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-key'),

                            TextInput::make('password_confirmation')
                                ->label('Confirmar Contraseña')
                                ->password()
                                ->revealable()
                                ->required(fn(string $operation): bool => $operation === 'create')
                                ->same('password')
                                ->dehydrated(false)
                                ->prefixIcon('heroicon-m-check-circle'),
                        ]),
                    ]),

                Section::make('Seguridad y Permisos')
                    ->description('Administración de roles y capacidades dentro del sistema.')
                    ->icon('heroicon-m-shield-check')
                    ->collapsed()
                    ->schema([
                        Select::make('roles')
                            ->label('Roles de Usuario')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable()
                            ->prefixIcon('heroicon-m-user-group')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
