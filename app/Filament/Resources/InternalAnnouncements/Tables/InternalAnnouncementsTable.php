<?php

namespace App\Filament\Resources\InternalAnnouncements\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalAnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('author.name')
                    ->label('Creado por'),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->since()
                    ->sortable(),
            ]);
    }
}
