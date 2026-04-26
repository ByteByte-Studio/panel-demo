<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Enums\AppointmentStatus;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    protected static ?string $title = 'Historial de Citas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Programación y Motivo')
                    ->icon('heroicon-m-calendar-days')
                    ->columns(3)
                    ->schema([
                        DateTimePicker::make('date_time')
                            ->label('Fecha y Hora')
                            ->required()
                            ->seconds(false)
                            ->native(false)
                            ->prefixIcon('heroicon-m-clock'),

                        TextInput::make('reason')
                            ->label('Asunto de la Cita')
                            ->placeholder('Ej: Revisión de pruebas para el caso...')
                            ->required()
                            ->columnSpan(2)
                            ->prefixIcon('heroicon-m-chat-bubble-left-ellipsis'),
                    ]),

                Section::make('Logística y Responsable')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->columns(3)
                    ->schema([
                        Select::make('responsable_lawyer')
                            ->label('Abogado Asignado')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-user-circle'),

                        Select::make('status')
                            ->label('Estado')
                            ->options(AppointmentStatus::options())
                            ->default(AppointmentStatus::Pending->value)
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag'),

                        Select::make('modality')
                            ->label('Modalidad')
                            ->options([
                                'Presencial' => 'Presencial',
                                'Online' => 'Videollamada',
                                'Llamada' => 'Telefónica',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-video-camera'),
                    ]),

                Section::make('Notas de la Sesión')
                    ->icon('heroicon-m-document-text')
                    ->collapsed()
                    ->schema([
                        RichEditor::make('notes')
                            ->hiddenLabel()
                            ->placeholder('Registre aquí los acuerdos o puntos clave tratados en la cita...')
                            ->toolbarButtons(['bold', 'italic', 'bulletList'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reason')
            ->defaultSort('date_time', 'desc')
            ->columns([
                TextColumn::make('date_time')
                    ->label('Fecha y Hora')
                    ->formatStateUsing(fn($state) => ucfirst(Carbon::parse($state)->translatedFormat('D d M, h:i A')))
                    ->description(fn($record) => Carbon::parse($record->date_time)->diffForHumans())
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                TextColumn::make('reason')
                    ->label('Asunto')
                    ->searchable()
                    ->wrap()
                    ->limit(50),

                TextColumn::make('responsable.name')
                    ->label('Abogado')
                    ->size('sm')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(AppointmentStatus $state): string => $state->color())
                    ->formatStateUsing(fn(AppointmentStatus $state): string => $state->label()),

                TextColumn::make('modality')
                    ->label('Modalidad')
                    ->badge()
                    ->color('gray')
                    ->icon(fn(string $state): string => match ($state) {
                        'Online' => 'heroicon-m-wifi',
                        'Presencial' => 'heroicon-m-building-office',
                        'Llamada' => 'heroicon-m-phone',
                        default => 'heroicon-m-question-mark-circle',
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agendar Cita')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver(),
            ])
            ->recordActions([
                ViewAction::make()->icon('heroicon-m-eye'),
                EditAction::make()
                    ->label('Gestionar')
                    ->icon('heroicon-m-pencil-square')
                    ->slideOver(),
                DeleteAction::make(),
            ]);
    }
}
