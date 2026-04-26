<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;

class RecurrentPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'recurrentPayments';
    protected static ?string $title = 'Cobros Recurrentes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Definición del Contrato')
                    ->icon('heroicon-m-document-duplicate')
                    ->description('Establezca las condiciones del cobro periódico (Igualada).')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nombre del Plan / Concepto')
                            ->placeholder('Ej: Igualada Jurídica Mensual - 2026')
                            ->required()
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-tag'),

                        Grid::make(3)->schema([
                            TextInput::make('amount')
                                ->label('Cuota Recurrente')
                                ->numeric()
                                ->prefix('$')
                                ->required()
                                ->prefixIcon('heroicon-m-banknotes')
                                ->extraInputAttributes(['class' => 'font-bold']),

                            Select::make('frecuency')
                                ->label('Frecuencia de Cobro')
                                ->options([
                                    'Semanal' => 'Semanal',
                                    'Mensual' => 'Mensual',
                                    'Bimestral' => 'Bimestral',
                                    'Trimestral' => 'Trimestral',
                                    'Anual' => 'Anual',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-arrow-path'),

                            TextInput::make('agreed_payment_day')
                                ->label('Día de Corte')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(28)
                                ->suffix('de cada mes')
                                ->required()
                                ->prefixIcon('heroicon-m-calendar'),
                        ]),

                        Grid::make(2)->schema([
                            DatePicker::make('contract_start_date')
                                ->label('Inicio de Vigencia')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'),

                            Select::make('status')
                                ->label('Estado del Plan')
                                ->options([
                                    'Activa' => 'Activo',
                                    'Pausado' => 'En Suspensión',
                                    'Finalizado' => 'Concluido',
                                    'Cancelado' => 'Cancelado / Rescindido',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-shield-check'),
                        ]),

                        Textarea::make('description')
                            ->label('Descripción Detallada')
                            ->required()
                            ->placeholder('Describa qué servicios incluye esta cuota fija...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('contract_start_date', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Concepto / Plan')
                    ->searchable()
                    ->description(fn($record) => "Día de pago: {$record->agreed_payment_day} de cada mes"),

                TextColumn::make('amount')
                    ->label('Cuota')
                    ->money('MXN')
                    ->weight('bold')
                    ->color('primary')
                    ->alignEnd(),

                TextColumn::make('frecuency')
                    ->label('Frecuencia')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Activa' => 'success',
                        'Pausado' => 'warning',
                        'Cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Activa' => 'heroicon-m-check-circle',
                        'Pausado' => 'heroicon-m-pause-circle',
                        'Cancelado' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-information-circle',
                    }),

                TextColumn::make('contract_start_date')
                    ->label('Inició')
                    ->date('M Y')
                    ->color('gray')
                    ->size('sm'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nueva Igualada')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver(),
            ])
            ->recordActions([
                EditAction::make()->slideOver()->icon('heroicon-m-pencil-square'),
                DeleteAction::make(),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->client_type !== 'prospecto';
    }
}
