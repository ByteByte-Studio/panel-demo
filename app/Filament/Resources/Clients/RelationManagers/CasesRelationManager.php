<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Filament\Resources\ClientCases\ClientCaseResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Tapp\FilamentProgressBarColumn\Tables\Columns\ProgressBarColumn;

class CasesRelationManager extends RelationManager
{
    protected static string $relationship = 'cases';
    protected static ?string $title = 'Casos del Cliente';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('case_name')
            ->recordUrl(fn($record) => ClientCaseResource::getUrl('edit', ['record' => $record]))
            ->columns([
                TextColumn::make('case_name')
                    ->label('Caso')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-folder'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Abierto' => 'heroicon-m-lock-open',
                        'En Proceso' => 'heroicon-m-arrow-path',
                        'Pausado' => 'heroicon-m-pause-circle',
                        'Cerrado' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Abierto' => 'info',
                        'En Proceso' => 'primary',
                        'Pausado' => 'warning',
                        'Cerrado' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('case_type')
                    ->label('Materia')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-scale'),

                ProgressBarColumn::make('paidPorcentage')
                    ->label('Pagado')
                    ->maxValue(100)
                    ->lowThreshold(99)
                    ->successLabel(fn($state) => $state . '%')
                    ->warningLabel(fn($state) => $state . '%')
                    ->dangerLabel(fn($state) => $state . '%')
                    ->successColor('#004c7a')
                    ->warningColor('#ea580c')
                    ->dangerColor('#dc2626')
                    ->sortable(),

                TextColumn::make('responsable_lawyer')
                    ->label('Abogado')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create_case')
                    ->label('Nuevo Caso')
                    ->icon('heroicon-m-plus-circle')
                    ->button()
                    ->url(fn() => ClientCaseResource::getUrl('create', [
                        'client_id' => $this->getOwnerRecord()->id,
                    ])),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Gestionar')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn($record) => ClientCaseResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->client_type !== 'prospecto';
    }
}
