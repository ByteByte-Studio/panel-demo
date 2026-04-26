<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Comprobante de Ingreso')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('amount')
                            ->label('Monto Total')
                            ->money('MXN')
                            ->weight(FontWeight::Bold)
                            ->color('success'),

                        Grid::make(2)->schema([
                            TextEntry::make('created_at')
                                ->label('Fecha de Recepción')
                                ->date('d F Y, H:i A')
                                ->icon('heroicon-m-calendar'),

                            TextEntry::make('payment_method')
                                ->label('Método de Pago')
                                ->badge(),

                            TextEntry::make('client.full_name')
                                ->label('Recibido de')
                                ->icon('heroicon-m-user'),

                            TextEntry::make('transaction_reference')
                                ->label('Referencia / Folio')
                                ->placeholder('—')
                                ->icon('heroicon-m-qr-code')
                                ->copyable(),
                        ]),

                        TextEntry::make('concept')
                            ->label('Concepto del Pago')
                            ->columnSpanFull()
                            ->markdown()
                            ->prose(),
                    ]),
            ]);
    }
}
