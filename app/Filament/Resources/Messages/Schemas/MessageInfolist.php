<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class MessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $formatPhone = function ($state) {
            if (! $state) {
                return '-';
            }
            $clean = preg_replace('/^521/', '', $state);
            if (strlen($clean) === 10) {
                return '+52 ' . substr($clean, 0, 3) . ' ' . substr($clean, 3, 3) . ' ' . substr($clean, 6);
            }

            return $state;
        };

        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)
                    ->schema([
                        Group::make([
                            Section::make('Contenido del Mensaje')
                                ->description('Detalle del texto enviado o recibido.')
                                ->icon('heroicon-m-chat-bubble-bottom-center-text')
                                ->columns(6)
                                ->schema([
                                    TextEntry::make('conversation.user_name')
                                        ->label('Nombre')
                                        ->columnSpan(2)
                                        ->icon('heroicon-m-user')
                                        ->placeholder('Sin nombre asignado'),

                                    TextEntry::make('message')
                                        ->label('')
                                        ->prose()
                                        ->columnSpan(4)
                                        ->weight(FontWeight::Medium),
                                ]),

                            Section::make('Visualización')
                                ->description('Vista previa del mensaje en el chat.')
                                ->icon('heroicon-m-eye')
                                ->schema([
                                    ViewEntry::make('preview')
                                        ->label('')
                                        ->view('filament.resources.conversations.components.message-preview')
                                        ->columnSpanFull(),
                                ]),
                        ])->columnSpan(2),

                        Group::make([
                            Section::make('Metadatos')
                                ->description('Información técnica.')
                                ->icon('heroicon-m-information-circle')
                                ->schema([
                                    TextEntry::make('role')
                                        ->label('Remitente')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'user' => 'success',
                                            'assistant' => 'info',
                                            default => 'gray',
                                        })
                                        ->formatStateUsing(fn(string $state): string => match ($state) {
                                            'user' => '👤 Usuario',
                                            'assistant' => '🤖 Sistema',
                                            default => $state,
                                        }),

                                    TextEntry::make('conversation.chat_id')
                                        ->label('Teléfono')
                                        ->icon('heroicon-m-phone')
                                        ->color('primary')
                                        ->copyable()
                                        ->formatStateUsing(fn($state) => $formatPhone($state))
                                        ->suffixAction(
                                            Action::make('open_whatsapp')
                                                ->icon('heroicon-m-arrow-top-right-on-square')
                                                ->color('success')
                                                ->url(fn($record) => "https://wa.me/{$record->chat_id}", true)
                                        ),
                                ]),

                            Section::make('Cronología')
                                ->description('Registro de tiempos.')
                                ->icon('heroicon-m-clock')
                                ->schema([
                                    TextEntry::make('created_at')
                                        ->label('Enviado el')
                                        ->dateTime('d/m/Y H:i:s')
                                        ->icon('heroicon-m-calendar-days'),

                                    TextEntry::make('created_at_human')
                                        ->label('Hace')
                                        ->state(fn($record) => $record?->created_at?->diffForHumans())
                                        ->color('gray')
                                        ->size('sm'),
                                ]),
                        ])->columnSpan(1),
                    ]),
            ]);
    }
}
