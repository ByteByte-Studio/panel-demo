<?php

namespace App\Filament\Resources\InternalAnnouncements;

use App\Filament\Resources\InternalAnnouncements\Pages\CreateInternalAnnouncement;
use App\Filament\Resources\InternalAnnouncements\Pages\EditInternalAnnouncement;
use App\Filament\Resources\InternalAnnouncements\Pages\ListInternalAnnouncements;
use App\Filament\Resources\InternalAnnouncements\Pages\ViewInternalAnnouncement;
use App\Filament\Resources\InternalAnnouncements\Schemas\InternalAnnouncementForm;
use App\Filament\Resources\InternalAnnouncements\Schemas\InternalAnnouncementInfolist;
use App\Filament\Resources\InternalAnnouncements\Tables\InternalAnnouncementsTable;
use App\Models\InternalAnnouncement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class InternalAnnouncementResource extends Resource
{
    protected static ?string $model = InternalAnnouncement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string | UnitEnum | null $navigationGroup = 'Comunicación';

    protected static ?string $modelLabel = 'Anuncio';

    public static function form(Schema $schema): Schema
    {
        return InternalAnnouncementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InternalAnnouncementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalAnnouncementsTable::configure($table);
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
            'index' => ListInternalAnnouncements::route('/'),
            'create' => CreateInternalAnnouncement::route('/create'),
            'view' => ViewInternalAnnouncement::route('/{record}'),
            'edit' => EditInternalAnnouncement::route('/{record}/edit'),
        ];
    }
}
