<?php

namespace App\Filament\Resources\InternalAnnouncements\Pages;

use App\Filament\Resources\InternalAnnouncements\InternalAnnouncementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalAnnouncements extends ListRecords
{
    protected static string $resource = InternalAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
