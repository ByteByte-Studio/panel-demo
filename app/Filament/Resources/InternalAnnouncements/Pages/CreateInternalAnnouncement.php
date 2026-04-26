<?php

namespace App\Filament\Resources\InternalAnnouncements\Pages;

use App\Filament\Resources\InternalAnnouncements\InternalAnnouncementResource;
use App\Models\User;
use App\WhatsApp\WhatsApp;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalAnnouncement extends CreateRecord
{
    protected static string $resource = InternalAnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $notifyWhatsapp = $this->data['notify_whatsapp'] ?? false;

        if (! $notifyWhatsapp) {
            return;
        }

        User::query()
            ->where('has_wa', true)
            ->whereNotNull('phone_number')
            ->each(function (User $user) {
                $message = "📢 *NUEVO ANUNCIO*: {$this->record->title}\n\n" .
                    "Puedes revisarlo en el sistema.";

                WhatsApp::sendText($user->phone_number, $message);
            });
    }
}
