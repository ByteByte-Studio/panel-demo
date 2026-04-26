<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientsResource;
use App\WhatsApp\WhatsApp;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EditClients extends EditRecord
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('imprimir')
                ->label('Imprimir PDF')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn() => route('cliente.imprimir', $this->record))
                ->openUrlInNewTab(),

            Action::make('convertirACliente')
                ->label('Confirmar como Cliente')
                ->icon('heroicon-m-user-plus')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Confirmar Cliente Activo')
                ->modalDescription('¿Deseas promover a este prospecto a cliente activo? Esto habilitará las funciones de expediente y cobranza.')
                ->visible(fn() => $this->record->client_type === 'prospecto')
                ->action(function () {
                    $this->record->update(['client_type' => 'cliente']);
                    $this->refreshFormData(['client_type']);

                    Notification::make()
                        ->title('Cliente confirmado exitosamente')
                        ->success()
                        ->send();
                }),

            ActionGroup::make([
                Action::make('mandarLinkEditarPerfil')
                    ->label('Enviar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->requiresConfirmation()
                    ->modalDescription('Se enviará un mensaje de WhatsApp con un acceso seguro para que el cliente actualice su información personal.')
                    ->action(function () {
                        $link = URL::temporarySignedRoute(
                            'cliente.editar-perfil',
                            now()->addHours(24),
                            ['client' => $this->record->id]
                        );

                        $sent = WhatsApp::sendText(
                            $this->record->phone_number,
                            "Hola {$this->record->full_name}, puedes actualizar tu información aquí (expira en 24h): {$link}"
                        );

                        $this->notifyWhatsAppStatus($sent);
                    }),

                Action::make('copiarLinkEditarPerfil')
                    ->label('Copiar Enlace')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->action(function () {
                        $link = URL::temporarySignedRoute(
                            'cliente.editar-perfil',
                            now()->addHours(24),
                            ['client' => $this->record->id]
                        );
                        $this->js("navigator.clipboard.writeText('{$link}');");
                        Notification::make()->title('Enlace de actualización copiado')->success()->send();
                    }),
            ])
            ->label('Actualizar Datos')
            ->icon('heroicon-m-user-circle')
            ->button()
            ->color('gray')
            ->outlined()
            ->visible(fn() => $this->record->client_type === 'cliente'),

            ActionGroup::make([
                Action::make('mandarLinkDocumentos')
                    ->label('Enviar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->action(function () {
                        $link = route('cliente.documentos', ['client' => $this->record->id]);

                        $sent = WhatsApp::sendText(
                            $this->record->phone_number,
                            "Hola {$this->record->full_name}, por favor sube tus documentos aquí: {$link}"
                        );

                        $this->notifyWhatsAppStatus($sent);
                    }),

                Action::make('copiarLinkDocumentos')
                    ->label('Copiar Enlace')
                    ->icon('heroicon-m-link')
                    ->action(function () {
                        $link = route('cliente.documentos', ['client' => $this->record->id]);
                        $this->js("navigator.clipboard.writeText('{$link}');");
                        Notification::make()->title('Enlace de carga de documentos copiado')->success()->send();
                    }),
            ])
                ->label('Pedir Documentos')
                ->icon('heroicon-m-document-plus')
                ->button()
                ->color('gray')
                ->outlined()
                ->visible(fn() => $this->record->client_type === 'cliente'),

            DeleteAction::make()
                ->label('Eliminar Registro')
                ->icon('heroicon-m-trash')
                ->outlined()
                ->color('danger'),
        ];
    }

    protected function notifyWhatsAppStatus(bool $sent): void
    {
        Notification::make()
            ->title($sent ? 'Notificación enviada con éxito' : 'Fallo en el servicio de WhatsApp')
            ->color($sent ? 'success' : 'danger')
            ->icon($sent ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-circle')
            ->send();
    }
}
