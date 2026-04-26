<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Enums\PaymentStatus;
use App\Enums\PaymentNotificationStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ClientPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $title = 'Historial de Pagos';

    protected function getTableQuery(): Builder
    {
        return $this->getOwnerRecord()->allPayments();
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->client_type !== 'prospecto';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Cobro')
                    ->icon('heroicon-m-banknotes')
                    ->columns(2)
                    ->schema([
                        TextInput::make('amount')
                            ->label('Monto')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        Select::make('payment_status')
                            ->label('Estado de Pago')
                            ->options(PaymentStatus::options())
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-check-circle'),

                        TextInput::make('concept')
                            ->label('Concepto / Motivo')
                            ->placeholder('Ej. Mensualidad, Trámite de Visa...')
                            ->required()
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-document-text'),

                        Select::make('payment_method')
                            ->label('Método de Pago')
                            ->options([
                                'Efectivo' => 'Efectivo',
                                'Transferencia' => 'Transferencia Electrónica',
                                'Tarjeta de Crédito/Débito' => 'Tarjeta Crédito/Débito',
                                'Cheque' => 'Cheque',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-credit-card'),

                        DatePicker::make('due_date')
                            ->label('Fecha de Vencimiento')
                            ->native(false)
                            ->prefixIcon('heroicon-m-calendar-days'),
                    ]),

                Section::make('Seguimiento y Notificaciones')
                    ->icon('heroicon-m-bell')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_notification_enabled')
                            ->label('Habilitar recordatorios automáticos')
                            ->helperText('Se enviarán alertas de WhatsApp antes y después del vencimiento.')
                            ->onIcon('heroicon-m-bell')
                            ->offIcon('heroicon-m-bell-slash')
                            ->default(true)
                            ->inline(false),

                        TextInput::make('transaction_reference')
                            ->label('Referencia / Folio')
                            ->placeholder('Núm. de ticket o rastreo')
                            ->prefixIcon('heroicon-m-ticket'),

                        Hidden::make('client_id')
                            ->default(fn($livewire) => $livewire->getOwnerRecord()->id),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('due_date')
                    ->label('Vence')
                    ->date('d/M/Y')
                    ->sortable()
                    ->color(fn($record) => $record->due_date?->isPast() && $record->payment_status !== PaymentStatus::Paid ? 'danger' : 'gray'),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->searchable()
                    ->description(fn($record) => $record->payment_method),

                TextColumn::make('payment_status')
                    ->label('Estado')
                    ->formatStateUsing(fn(PaymentStatus $state) => $state->label())
                    ->color(fn(PaymentStatus $state) => $state->color())
                    ->badge(),

                TextColumn::make('payment_method')
                    ->label('Método')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Efectivo' => 'heroicon-m-banknotes',
                        'Transferencia' => 'heroicon-m-arrows-right-left',
                        'Tarjeta de Crédito/Débito' => 'heroicon-m-credit-card',
                        'Cheque' => 'heroicon-m-document-check',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Efectivo' => 'success',
                        'Transferencia' => 'info',
                        'Tarjeta de Crédito/Débito' => 'primary',
                        'Cheque' => 'warning',
                        default => 'gray',
                    }),

                ToggleColumn::make('is_notification_enabled')
                    ->label('Notificaciones')
                    ->onIcon('heroicon-m-bell')
                    ->offIcon('heroicon-m-bell-slash'),

                TextColumn::make('amount')
                    ->label('Importe')
                    ->money('MXN')
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd()
                    ->summarize(Sum::make()->label('Total')->money('MXN')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Registrar Pago')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver(),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ]);
    }
}
