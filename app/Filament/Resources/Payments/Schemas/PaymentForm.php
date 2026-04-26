<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\ClientCase;
use App\Models\Procedure;
use App\Models\RecurrentPayment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Detalles de la Transacción')
                    ->icon('heroicon-m-banknotes')
                    ->columnSpan(7)
                    ->schema([
                        Select::make('client_id')
                            ->label('Cliente que realiza el pago')
                            ->relationship('client', 'full_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            TextInput::make('amount')
                                ->label('Monto Recibido')
                                ->numeric()
                                ->prefix('$')
                                ->required()
                                ->extraInputAttributes(['class' => 'font-bold text-lg']),

                            Select::make('payment_method')
                                ->label('Método de Pago')
                                ->options([
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia Bancaria',
                                    'Tarjeta' => 'Tarjeta Crédito/Débito',
                                    'Cheque' => 'Cheque',
                                ])
                                ->required()
                                ->native(false),
                        ]),

                        TextInput::make('concept')
                            ->label('Concepto / Motivo')
                            ->placeholder('Ej. Abono a trámite migratorio...')
                            ->required()
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text'),

                        TextInput::make('transaction_reference')
                            ->label('Referencia / Folio de rastreo')
                            ->placeholder('Núm. de autorización o SPEI')
                            ->prefixIcon('heroicon-m-ticket'),
                    ]),

                Section::make('Destino del Pago')
                    ->description('¿A qué expediente o gestión se aplica este ingreso?')
                    ->icon('heroicon-m-link')
                    ->columnSpan(5)
                    ->schema([
                        Select::make('paymentable_selector')
                            ->label('Tipo de Destino')
                            ->options([
                                'case' => 'Expediente / Caso',
                                'procedure' => 'Trámite Específico',
                                'recurrent' => 'Plan de Igualada',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        Select::make('case_id')
                            ->label('Seleccionar Expediente')
                            ->options(fn (Get $get) =>
                                ClientCase::where('client_id', $get('client_id'))
                                    ->pluck('case_name', 'id')
                            )
                            ->searchable()
                            ->visible(fn (Get $get) => $get('paymentable_selector') === 'case' && $get('client_id'))
                            ->required()
                            ->dehydrated()
                            ->prefixIcon('heroicon-m-briefcase'),

                        Select::make('procedure_id')
                            ->label('Seleccionar Trámite')
                            ->options(fn (Get $get) =>
                                Procedure::whereHas('clientCase', fn($q) => $q->where('client_id', $get('client_id')))
                                    ->pluck('title', 'id')
                            )
                            ->searchable()
                            ->visible(fn (Get $get) => $get('paymentable_selector') === 'procedure' && $get('client_id'))
                            ->required()
                            ->dehydrated()
                            ->prefixIcon('heroicon-m-clipboard-document-list'),

                        Select::make('recurrent_id')
                            ->label('Seleccionar Plan de Pago')
                            ->options(fn (Get $get) =>
                                RecurrentPayment::where('client_id', $get('client_id'))
                                    ->pluck('title', 'id')
                            )
                            ->visible(fn (Get $get) => $get('paymentable_selector') === 'recurrent' && $get('client_id'))
                            ->required()
                            ->dehydrated()
                            ->prefixIcon('heroicon-m-arrow-path'),

                        TextEntry::make('help')
                            ->hiddenLabel()
                            ->state('Seleccione primero un cliente para ver sus expedientes o trámites.')
                            ->visible(fn (Get $get) => !$get('client_id')),
                    ]),
            ]);
    }
}
