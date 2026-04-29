<?php

namespace App\Filament\Resources\InternalAnnouncements\Pages;

use App\Filament\Resources\InternalAnnouncements\InternalAnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalAnnouncement extends CreateRecord
{
    protected static string $resource = InternalAnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
