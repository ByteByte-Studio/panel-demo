<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Producto')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Producto')
                            ->weight('bold')
                            ->size('lg'),

                        IconEntry::make('is_active')
                            ->label('Estado')
                            ->boolean(),

                        TextEntry::make('sku')
                            ->label('SKU')
                            ->copyable(),

                        TextEntry::make('price')
                            ->label('Precio')
                            ->money('MXN'),

                        TextEntry::make('stock')
                            ->label('Existencias'),

                        TextEntry::make('description')
                            ->label('Descripción')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Section::make('Galería')
                    ->schema([
                        ImageEntry::make('images')
                            ->label('Imágenes')
                            ->circular()
                            ->stacked()
                            ->limit(5),
                    ]),
            ]);
    }
}
