<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\CreateClients;
use App\Filament\Resources\Clients\Pages\EditClients;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Filament\Resources\Clients\RelationManagers\AppointmentsRelationManager;
use App\Filament\Resources\Clients\RelationManagers\ClientPaymentsRelationManager;
use App\Filament\Resources\Clients\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\Clients\Schemas\ClientsForm;
use App\Filament\Resources\Clients\Tables\ClientsTable;
use App\Models\Client;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ClientsResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static string|UnitEnum|null $navigationGroup = 'Gestión de Clientes';

    protected static ?string $modelLabel = 'Expediente';

    protected static ?string $pluralModelLabel = 'Expedientes';

    protected static ?string $model = Client::class;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['full_name', 'email', 'phone_number'];
    }

    public static function form(Schema $schema): Schema
    {
        return ClientsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DocumentsRelationManager::class,
            AppointmentsRelationManager::class,
            ClientPaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClients::route('/'),
            'create' => CreateClients::route('/create'),
            'edit' => EditClients::route('/{record}/edit'),
        ];
    }
}
