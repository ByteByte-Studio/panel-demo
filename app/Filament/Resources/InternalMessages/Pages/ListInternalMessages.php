<?php

namespace App\Filament\Resources\InternalMessages\Pages;

use App\Filament\Resources\InternalMessages\InternalMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListInternalMessages extends ListRecords
{
    protected static string $resource = InternalMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Redactar Mensaje')
                ->icon('heroicon-m-pencil-square'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->where(function (Builder $query) {
                $query->where('sender_id', auth()->id())
                    ->orWhereHas('recipients', fn ($q) => $q->where('users.id', auth()->id())
                    );
            });
    }

    public function getTabs(): array
    {
        return [
            'received' => Tab::make('Bandeja de Entrada')
                ->icon('heroicon-m-inbox')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('recipients', fn ($q) => $q->where('users.id', auth()->id())
                )
                ),

            'sent' => Tab::make('Enviados')
                ->icon('heroicon-m-paper-airplane')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('sender_id', auth()->id())
                ),

            'all' => Tab::make('Todos')
                ->label('Historial Completo')
                ->icon('heroicon-m-archive-box'),
        ];
    }

    public function getDefaultActiveTab(): string
    {
        return 'received';
    }
}
