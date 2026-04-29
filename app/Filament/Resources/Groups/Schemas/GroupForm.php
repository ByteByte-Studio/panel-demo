<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group as ComponentsGroup;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                ComponentsGroup::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Detalles del Grupo')
                            ->description('Configuración principal de la logística y capacidad.')
                            ->icon('heroicon-m-clipboard-document-list')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Grupo')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ej: Entrevistas Turno Mañana')
                                    ->columnSpan(1),

                                DateTimePicker::make('date_time')
                                    ->label('Fecha de Entrevista')
                                    ->required()
                                    ->seconds(false)
                                    ->native(false)
                                    ->displayFormat('d/m/Y H:i')
                                    ->minutesStep(15),

                                TextInput::make('location')
                                    ->label('Dirección')
                                    ->placeholder('Av. Principal #123...')
                                    ->prefixIcon('heroicon-m-map-pin'),

                                TextInput::make('location_link')
                                    ->label('Link de Google Maps')
                                    ->url()
                                    ->placeholder('https://maps.google.com/...')
                                    ->prefixIcon('heroicon-m-link'),
                            ]),

                        Section::make('Instrucciones para Aplicantes')
                            ->collapsible()
                            ->schema([
                                Textarea::make('message')
                                    ->label('Mensaje de Bienvenida')
                                    ->rows(5)
                                    ->helperText('Este mensaje será enviado por WhatsApp al confirmar.'),
                            ]),
                    ]),

                ComponentsGroup::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Estado y Capacidad')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aceptar Registros')
                                    ->helperText('Activa o desactiva la visibilidad del grupo.')
                                    ->onColor('success')
                                    ->default(true),

                                TextInput::make('capacity')
                                    ->label('Capacidad Máxima')
                                    ->default(25)
                                    ->numeric()
                                    ->required()
                                    ->prefixIcon('heroicon-m-ticket')
                                    ->minValue(fn (Get $get) => $get('current_members_count') ?? 0),
                            ]),

                        Section::make('Datos')
                            ->description('Información del sistema')
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Creado')
                                    ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? '-'),

                                TextInput::make('current_members_count')
                                    ->label('Miembros Actuales')
                                    ->numeric()
                                    ->readOnly()
                                    ->columnSpan(5)
                                    ->disabled()
                                    ->prefixIcon('heroicon-m-users'),
                            ])->visible(fn ($record) => $record !== null),
                    ]),
            ]);
    }
}
