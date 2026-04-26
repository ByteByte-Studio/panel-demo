<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
use App\WhatsApp\WhatsApp; //
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAppointments extends EditRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('date_time')) {
            $this->sendTimeChangeNotification();
        }
    }

    protected function sendTimeChangeNotification(): void
    {
        $recipient = $this->record->appointmentable;
        $phone = $recipient?->phone_number;

        if (!filled($phone)) {
            Notification::make()
                ->title('No se pudo enviar WhatsApp')
                ->body('El cliente no tiene un número de teléfono registrado.')
                ->warning()
                ->send();

            return;
        }

        $newTime = $this->record->date_time->format('l, j \d\e F \a \l\a\s H:i');
        $message = "Hola {$recipient->full_name}, te informamos que tu cita ha sido REPROGRAMADA. La nueva fecha y hora es: {$newTime}.";

        $sent = WhatsApp::sendText($phone, $message);

        if ($sent) {
            Notification::make()
                ->title('Notificación enviada')
                ->body("Se informó al cliente sobre el cambio de horario a las {$newTime}.")
                ->success()
                ->send();
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load('appointmentable');

        if ($record->appointmentable?->client_type === 'prospecto') {
            $data['appointment_mode'] = 'prospect';

            $data['prospect_full_name'] = $record->appointmentable->full_name;
            $data['prospect_phone']     = $record->appointmentable->phone_number;
            $data['prospect_email']     = $record->appointmentable->email;
        } else {
            $data['appointment_mode'] = 'client';
        }

        return $data;
    }
}
