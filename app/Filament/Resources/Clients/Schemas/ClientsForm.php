<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Get;

class ClientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Identidad')
                    ->icon('heroicon-m-identification')
                    ->description('Defina la naturaleza jurídica y el nombre oficial del cliente.')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('person_type')
                                ->label('Naturaleza Jurídica')
                                ->options([
                                    'persona_fisica' => 'Persona Física',
                                    'persona_moral' => 'Persona Moral (Empresa)',
                                ])
                                ->required()
                                ->native(false)
                                ->live()
                                ->prefixIcon('heroicon-m-scale'),

                            TextInput::make('full_name')
                                ->label(fn(Get $get) => $get('person_type') === 'persona_moral' ? 'Razón Social' : 'Nombre Completo')
                                ->placeholder(fn(Get $get) => $get('person_type') === 'persona_moral' ? 'Ej. Corporativo Jurídico Zúñiga S.A. de C.V.' : 'Ej. Juan Pérez Hernández')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2)
                                ->prefixIcon('heroicon-m-user'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('occupation')
                                ->label(
                                    fn(Get $get) => $get('person_type') === 'persona_moral'
                                        ? 'Giro Comercial'
                                        : 'Ocupación / Profesión'
                                )
                                ->placeholder('Ej. Servicios Médicos, Ingeniero, etc.')
                                ->prefixIcon('heroicon-m-briefcase'),

                            DatePicker::make('date_of_birth')
                                ->label(fn (Get $get) => $get('person_type') === 'persona_moral' ? 'Fecha de Constitución' : 'Fecha de Nacimiento')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar'),
                        ]),
                    ]),

                Section::make('Canales de Comunicación')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->description('Datos necesarios para notificaciones y seguimiento vía WhatsApp.')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone_number')
                                ->label('Teléfono Móvil (WhatsApp)')
                                ->tel()
                                ->required()
                                ->placeholder('5512345678')
                                ->prefixIcon('heroicon-m-device-phone-mobile')
                                ->mask('999999999999'),

                            TextInput::make('email')
                                ->label('Correo Electrónico')
                                ->email()
                                ->placeholder('cliente@ejemplo.com')
                                ->prefixIcon('heroicon-m-at-symbol'),
                        ]),

                        Textarea::make('address')
                            ->label('Domicilio Legal / Fiscal')
                            ->rows(3)
                            ->autosize()
                            ->placeholder('Calle, Número, Colonia, Ciudad, Estado y Código Postal')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'resize-none']),
                    ]),

                Section::make('Documentación Fiscal y Oficial')
                    ->icon('heroicon-m-document-check')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('rfc')
                                ->label('RFC')
                                ->placeholder('ABCD010101XXX')
                                ->prefixIcon('heroicon-m-finger-print')
                                ->maxLength(13)
                                ->extraInputAttributes(['style' => 'text-transform: uppercase']),

                            TextInput::make('curp')
                                ->label('CURP')
                                ->placeholder('ABCD010101HDFRLL01')
                                ->prefixIcon('heroicon-m-identification')
                                ->maxLength(18)
                                ->visible(fn(Get $get) => $get('person_type') === 'persona_fisica')
                                ->extraInputAttributes(['style' => 'text-transform: uppercase']),
                        ]),
                    ]),
            ]);
    }
}
