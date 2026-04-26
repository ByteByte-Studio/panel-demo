<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Enums\AppointmentStatus;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ClientCases\ClientCaseResource;

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
                                ->iconColor("primary")
                                ->copyable(),

                            TextEntry::make('responsable.name')
                                ->label('Abogado Responsable')
                                ->iconColor("primary")
                                ->icon('heroicon-m-briefcase')
                                ->copyable(),

                            TextEntry::make('case.case_name')
                                ->label('Expediente Relacionado')
                                ->placeholder('Sin expediente vinculado')
                                ->suffixAction(
                                    Action::make('view_case')
                                        ->icon('heroicon-m-arrow-top-right-on-square')
                                        ->tooltip('Ir al expediente')
                                        ->url(fn($record) => $record->case ? ClientCaseResource::getUrl('edit', ['record' => $record->case]) : null)
                                )
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
