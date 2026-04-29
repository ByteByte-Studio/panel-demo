<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Enums\AppointmentStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AppointmentsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('date_time')
                                    ->columnSpanFull()
                                    ->label('Fecha y Hora')
                                    ->dateTime('d F, Y - h:i A'),

                                TextEntry::make('status')
                                    ->label('Estado')
                                    ->badge()
                                    ->formatStateUsing(fn (AppointmentStatus $state) => $state->label())
                                    ->color(fn (AppointmentStatus $state) => $state->color()),

                                TextEntry::make('modality')
                                    ->label('Modalidad')
                                    ->badge(),
                            ]),
                    ]),

                Section::make('Detalles del Caso')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('appointmentable.full_name')
                                ->label('Cliente')
                                ->icon('heroicon-m-user')
                                ->iconColor('primary')
                                ->copyable()
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Contenido')
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        TextEntry::make('reason')
                            ->label('Motivo de la cita')
                            ->columnSpanFull(),

                        TextEntry::make('notes')
                            ->label('Notas Internas')
                            ->placeholder('Sin notas registradas')
                            ->markdown()
                            ->columnSpanFull()
                            ->prose(),
                    ]),
            ]);
    }
}
