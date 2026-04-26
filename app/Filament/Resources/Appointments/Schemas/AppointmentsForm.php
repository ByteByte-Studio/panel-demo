<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Enums\AppointmentStatus;
use App\Models\Client;
use App\Models\ClientCase;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class AppointmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Configuración de la Cita')
                    ->description('Defina el origen del interesado y la modalidad de la reunión.')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->columns(2)
                    ->schema([
                        Select::make('appointment_mode')
                            ->label('Origen del interesado')
                            ->options([
                                'client' => 'Cliente Existente',
                                'prospect' => 'Nuevo Prospecto',
                            ])
                            ->default('client')
                            ->live()
                            ->required()
                            ->disabledOn('edit')
                            ->dehydrated(false)
                            ->prefixIcon('heroicon-m-identification'),

                        Select::make('modality')
                            ->label('Modalidad')
                            ->options([
                                'Presencial' => 'Presencial',
                                'Online' => 'Online',
                                'Llamada' => 'Llamada',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-video-camera'),
                    ]),

                Section::make('Identificación del Cliente')
                    ->description('Seleccione al cliente y el caso legal vinculado.')
                    ->icon('heroicon-m-user')
                    ->visible(fn (Get $get) => $get('appointment_mode') === 'client')
                    ->schema([
                        Select::make('appointmentable_id')
                            ->label('Cliente')
                            ->placeholder('Busque por nombre...')
                            ->options(Client::where('client_type', '!=', 'prospecto')->pluck('full_name', 'id'))
                            ->searchable()
                            ->disabledOn('edit')
                            ->live()
                            ->required(fn (Get $get) => $get('appointment_mode') === 'client')
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-magnifying-glass'),

                        Select::make('case_id')
                            ->label('Caso relacionado')
                            ->placeholder('Seleccione un expediente activo (opcional)')
                            ->options(fn (Get $get) =>
                                ClientCase::where('client_id', $get('appointmentable_id'))
                                    ->pluck('case_name', 'id')
                            )
                            ->searchable()
                            ->visible(fn (Get $get) => filled($get('appointmentable_id')))
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-briefcase'),
                    ]),

                Section::make('Datos del Nuevo Prospecto')
                    ->description('Información básica para el registro inicial del interesado.')
                    ->icon('heroicon-m-user-plus')
                    ->visible(fn (Get $get) => $get('appointment_mode') === 'prospect')
                    ->schema([
                        TextInput::make('prospect_full_name')
                            ->label('Nombre completo')
                            ->placeholder('Ej. María García López')
                            ->disabledOn('edit')
                            ->required(fn (Get $get) => $get('appointment_mode') === 'prospect')
                            ->prefixIcon('heroicon-m-user-circle'),

                        Grid::make(2)->schema([
                            TextInput::make('prospect_phone')
                                ->label('Teléfono de contacto')
                                ->placeholder('55 1234 5678')
                                ->tel()
                                ->disabledOn('edit')
                                ->required(fn (Get $get) => $get('appointment_mode') === 'prospect')
                                ->prefixIcon('heroicon-m-phone'),

                            TextInput::make('prospect_email')
                                ->label('Correo electrónico')
                                ->placeholder('prospecto@ejemplo.com')
                                ->disabledOn('edit')
                                ->email()
                                ->prefixIcon('heroicon-m-envelope'),
                        ]),
                    ])
                    ->dehydrated(false),

                Section::make('Programación y Responsable')
                    ->description('Establezca la fecha, hora y el abogado encargado de la atención.')
                    ->icon('heroicon-m-calendar-days')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        DateTimePicker::make('date_time')
                            ->label('Fecha y hora')
                            ->required()
                            ->seconds(false)
                            ->native(false)
                            ->prefixIcon('heroicon-m-clock'),

                        Select::make('responsable_lawyer')
                            ->label('Abogado responsable')
                            ->relationship('responsable', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->prefixIcon('heroicon-m-academic-cap'),

                        Select::make('status')
                            ->label('Estado de la cita')
                            ->options(AppointmentStatus::options())
                            ->default(AppointmentStatus::Pending)
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-arrow-path-rounded-square'),
                    ]),

                Section::make('Información del Asunto')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('reason')
                            ->label('Motivo de la cita')
                            ->placeholder('Describa brevemente el asunto a tratar o notas importantes...')
                            ->rows(4)
                            ->autosize()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
