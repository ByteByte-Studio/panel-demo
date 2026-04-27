<?php

namespace App\Filament\Resources\Conversations\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConversationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $formatPhone = function ($state) {
            if (! $state) {
                return '-';
            }

            $clean = preg_replace('/^521/', '', $state);

            if (strlen($clean) === 10) {
                return '+52 '.substr($clean, 0, 3).' '.substr($clean, 3, 3).' '.substr($clean, 6);
            }

            return $state;
        };

        return $schema
            ->components([
                Section::make('Perfil del Cliente')
                    ->description('Detalles del contacto y origen de la conversación.')
                    ->icon('heroicon-m-user-circle')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user_name')
                            ->label('Nombre')
                            ->placeholder('Nombre no registrado'),

                        TextEntry::make('chat_id')
                            ->label('Teléfono')
                            ->icon('heroicon-m-phone')
                            ->color('primary')
                            ->copyable()
                            ->formatStateUsing(fn ($state) => $formatPhone($state))
                            ->suffixAction(
                                Action::make('open_whatsapp')
                                    ->icon('heroicon-m-arrow-top-right-on-square')
                                    ->color('success')
                                    ->url(fn ($record) => "https://wa.me/{$record->chat_id}", true)
                            ),
                    ]),

                Section::make('Métricas y Resumen')
                    ->description('Estadísticas rápidas de la actividad.')
                    ->icon('heroicon-m-chart-bar')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('messages_count')
                            ->label('Total de Mensajes')
                            ->state(fn ($record) => $record->messages()->count())
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-m-chat-bubble-left-right'),

                        TextEntry::make('last_role')
                            ->label('Estado de Respuesta')
                            ->state(fn ($record) => $record->latestMessage?->role === 'assistant' ? 'Bot respondió último' : 'Esperando respuesta del Bot')
                            ->badge()
                            ->color(fn ($state) => str_contains($state, 'Bot') && ! str_contains($state, 'Esperando') ? 'success' : 'warning')
                            ->icon(fn ($state) => str_contains($state, 'Bot') && ! str_contains($state, 'Esperando') ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-circle'),
                    ]),

                Section::make('Estado de la Conversación')
                    ->description('Información adicional sobre el contexto actual.')
                    ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Registro Inicial')
                            ->icon('heroicon-m-calendar')
                            ->dateTime('d M Y, h:i A'),

                        TextEntry::make('updated_at')
                            ->label('Última Interacción')
                            ->icon('heroicon-m-clock')
                            ->dateTime('d M Y, h:i A'),
                    ]),
            ]);
    }
}
