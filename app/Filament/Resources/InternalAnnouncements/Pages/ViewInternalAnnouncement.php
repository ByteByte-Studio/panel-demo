<?php

namespace App\Filament\Resources\InternalAnnouncements\Pages;

use App\Filament\Resources\InternalAnnouncements\InternalAnnouncementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInternalAnnouncement extends ViewRecord
{
    protected static string $resource = InternalAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
