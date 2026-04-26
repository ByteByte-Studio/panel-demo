<?php

namespace App\Filament\Resources\InternalMessages;

use App\Filament\Resources\InternalMessages\Pages\CreateInternalMessage;
use App\Filament\Resources\InternalMessages\Pages\EditInternalMessage;
use App\Filament\Resources\InternalMessages\Pages\ViewInternalMessage;
use App\Filament\Resources\InternalMessages\Pages\ListInternalMessages;
use App\Filament\Resources\InternalMessages\Schemas\InternalMessageForm;
use App\Filament\Resources\InternalMessages\Tables\InternalMessagesTable;
use App\Models\InternalMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class InternalMessageResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Comunicación';

    protected static ?string $modelLabel = 'Mensaje Interno';

    protected static ?string $pluralModelLabel = 'Mensajes Internos';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $model = InternalMessage::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereHas('recipients', function ($query) {
            $query->where('user_id', auth()->id())
                  ->whereNull('attended_at');
        })->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return InternalMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalMessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInternalMessages::route('/'),
            'create' => CreateInternalMessage::route('/create'),
            'edit' => EditInternalMessage::route('/{record}/edit'),
        ];
    }
}
