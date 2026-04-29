<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Producto')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            TextInput::make('sku')
                                ->label('SKU')
                                ->unique(ignoreRecord: true)
                                ->maxLength(50),

                            TextInput::make('price')
                                ->label('Precio')
                                ->numeric()
                                ->prefix('$')
                                ->required(),

                            TextInput::make('stock')
                                ->label('Existencias')
                                ->numeric()
                                ->default(0)
                                ->required(),
                        ]),
                    ]),

                Section::make('Multimedia y Estado')
                    ->icon('heroicon-m-photo')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Imágenes del Producto')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('product-images')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Producto Activo')
                            ->default(true)
                            ->onColor('success'),
                    ]),
            ]);
    }
}
