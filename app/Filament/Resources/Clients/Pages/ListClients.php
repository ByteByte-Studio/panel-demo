<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientsResource;
use App\Models\Client;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListClients extends ListRecords
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Registro')
                ->icon('heroicon-m-user-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'clients' => Tab::make('Clientes')
                ->icon('heroicon-m-user-group')
                ->badge(Client::where('client_type', 'cliente')->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('client_type', 'cliente')),

            'prospect' => Tab::make('Prospectos')
                ->icon('heroicon-m-user-plus')
                ->badge(Client::where('client_type', 'prospecto')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('client_type', 'prospecto')),

            'person' => Tab::make('Personas Físicas')
                ->icon('heroicon-m-user')
                ->badge(Client::where('person_type', 'persona_fisica')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('person_type', 'persona_fisica')),

            'company' => Tab::make('Personas Morales')
                ->icon('heroicon-m-building-office-2')
                ->badge(Client::where('person_type', 'persona_moral')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('person_type', 'persona_moral')),

            'all' => Tab::make('Todos')
                ->icon('heroicon-m-list-bullet')
                ->label('Ver Todos'),
        ];
    }
}
