<?php

namespace App\Filament\Resources\InternalMessages\Pages;

use App\Filament\Resources\InternalMessages\InternalMessageResource;
use App\WhatsApp\WhatsApp;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalMessage extends CreateRecord
{
    protected static string $resource = InternalMessageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sender_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $notifyWhatsapp = $this->data['notify_whatsapp'] ?? false;

        if (! $notifyWhatsapp) {
            return;
        }

        $senderName = auth()->user()->name;

        $this->record->recipients->each(function ($user) use ($senderName) {

            if ($user->has_wa && $user->phone_number) {
                $message = "📩 *MENSAJE NUEVO* de _{$senderName}_\n" .
                    "Asunto: *{$this->record->subject}*\n\n" .
                    "Puedes revisarlo en el sistema.";

                WhatsApp::sendText($user->phone_number, $message);
            }
        });
    }
}
