<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\Appointments\AppointmentsResource;
use App\WhatsApp\WhatsApp; // 👈 Importamos tu librería
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewAppointments extends ViewRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // UX: Agrupamos las acciones de estado para limpiar la cabecera
            ActionGroup::make([

                Action::make('accept')
                    ->label('Confirmar Cita')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription('¿Deseas confirmar esta cita y notificar al cliente por WhatsApp?')
                    ->action(function () {
                        $this->record->update(['status' => AppointmentStatus::Confirmed]);

                        $this->notifyViaWhatsApp(
                            "Hola {$this->record->appointmentable->full_name}, tu cita para el día " .
                            $this->record->date_time->format('l, j \d\e F \a \l\a\s H:i') . " ha sido CONFIRMADA. ¡Te esperamos!"
                        );

                        Notification::make()->title('Cita confirmada y cliente notificado.')->success()->send();
                        $this->refreshFormData(['status']);
                    }),

                Action::make('reschedule')
                    ->label('Proponer Reagendado')
                    ->icon('heroicon-m-calendar-days')
                    ->color('gray')
                    ->action(function () {
                        $this->record->update([
                            'status' => AppointmentStatus::RescheduleProposed,
                            'reschedule_proposed_at' => now(),
                        ]);

                        $this->notifyViaWhatsApp(
                            "Hola {$this->record->appointmentable->full_name}, necesitamos reprogramar tu cita. " .
                            "Por favor, revisa las nuevas opciones que te enviaremos en breve."
                        );

                        $this->redirect(static::$resource::getUrl('edit', ['record' => $this->record]));
                    }),

                Action::make('reject')
                    ->label('Cancelar / Rechazar')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('¿Rechazar cita?')
                    ->modalDescription('Esta acción notificará al cliente sobre la cancelación.')
                    ->action(function () {
                        $this->record->update(['status' => AppointmentStatus::Cancelled]);

                        $this->notifyViaWhatsApp(
                            "Lo sentimos {$this->record->appointmentable->full_name}, tu cita ha sido CANCELADA por motivos de agenda. " .
                            "Contacta con nosotros para más información."
                        );

                        Notification::make()->title('Cita cancelada.')->danger()->send();
                        $this->refreshFormData(['status']);
                    }),

            ])
            ->label('Gestionar Cita')
            ->icon('heroicon-m-ellipsis-vertical')
            ->color('gray')
            ->button(),

            EditAction::make(),
        ];
    }

    protected function notifyViaWhatsApp(string $message): void
    {
        $phone = $this->record->appointmentable->phone_number;

        if (filled($phone)) {
            WhatsApp::sendText($phone, $message);
        }
    }
}
