<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\Appointments\AppointmentsResource;
use App\WhatsApp\WhatsApp;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Cita')
                ->icon('heroicon-m-plus'),

            ActionGroup::make([
                Action::make('enviarSolicitudWhatsapp')
                    ->label('Enviar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('primary')
                    ->schema([
                        TextInput::make('phone_number')
                            ->label('Número de WhatsApp')
                            ->placeholder('Ej: 5215512345678')
                            ->tel()
                            ->required(),
                    ])
                    ->modalWidth('md')
                    ->action(function (array $data) {
                        $link = route('appointments.schedule');
                        $message = "Hola, te envío el link para que puedas subir tus documentos: {$link}";

                        $sent = WhatsApp::sendText($data['phone_number'], $message);

                        if ($sent) {
                            Notification::make()
                                ->title('Solicitud enviada')
                                ->body("Se envió el enlace al número {$data['phone_number']}.")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al enviar')
                                ->body('No se pudo establecer conexión con el servicio de WhatsApp.')
                                ->danger()
                                ->send();
                        }
                    }),

                Action::make('copiarLinkGenerarCita')
                    ->label('Copiar enlace directo')
                    ->icon('heroicon-m-clipboard-document')
                    ->color('gray')
                    ->action(function () {
                        $link = route('appointments.schedule');
                        $this->js("navigator.clipboard.writeText('{$link}');");

                        Notification::make()
                            ->title('Enlace copiado')
                            ->success()
                            ->send();
                    }),
            ])
                ->label('Pedir documentos')
                ->icon('heroicon-m-document-plus')
                ->button()
                ->color('gray')
                ->outlined(),
        ];
    }

    public function getTabs(): array
    {
        $model = static::$resource::getModel();

        return [
            'today' => Tab::make('Hoy')
                ->icon('heroicon-m-calendar')
                ->badge($model::whereDate('date_time', today())->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereDate('date_time', today())),

            'pending' => Tab::make('Pendientes')
                ->icon('heroicon-m-clock')
                ->badge($model::where('status', AppointmentStatus::Pending)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', AppointmentStatus::Pending)),

            'confirmed' => Tab::make('Confirmadas')
                ->icon('heroicon-m-check-badge')
                ->badge($model::where('status', AppointmentStatus::Confirmed)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', AppointmentStatus::Confirmed)),

            'tomorrow' => Tab::make('Mañana')
                ->icon('heroicon-m-calendar-days')
                ->badge($model::whereDate('date_time', today()->addDay())->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereDate('date_time', today()->addDay())),

            'all' => Tab::make('Todas')
                ->icon('heroicon-m-list-bullet'),
        ];
    }
}
