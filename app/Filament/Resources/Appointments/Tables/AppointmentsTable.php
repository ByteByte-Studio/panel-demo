<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Enums\AppointmentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_time')
                    ->label("Fecha")
                    ->dateTime('l d M Y, h:i A')
                    ->sortable()
                    ->description(fn($record) => Carbon::parse($record->date_time)->diffForHumans())
                    ->searchable(),

                TextColumn::make('appointmentable.full_name')
                    ->label("Cliente")
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('responsable.name')
                    ->label("Abogado")
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'Online' => 'heroicon-m-wifi',
                        'Presencial' => 'heroicon-m-building-office',
                        'Llamada' => 'heroicon-m-phone',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Presencial' => 'primary',
                        'Online' => 'info',
                        'Llamada' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    ->color(fn (AppointmentStatus $state) => $state->color())
                    ->formatStateUsing(fn (AppointmentStatus $state): string => $state->label()),
            ])
            ->defaultSort('date_time', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Estatus')
                    ->options(AppointmentStatus::options()),

                Filter::make('future')
                    ->label('Próximas Citas')
                    ->query(fn (Builder $query): Builder => $query->where('date_time', '>=', now()))
                    ->default(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
