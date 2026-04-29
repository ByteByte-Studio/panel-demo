<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Configuración General')
                    ->description('Definición básica de la etapa.')
                    ->icon('heroicon-m-adjustments-horizontal')
                    ->columns(1)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nombre de la Etapa')
                            ->prefixIcon('heroicon-m-tag')
                            ->placeholder('Ej. Entrevista Inicial')
                            ->maxLength(255),
                    ]),

                Section::make('Comunicación Automática')
                    ->description('Mensajes que recibirá el aplicante según el resultado de esta etapa.')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->collapsible()
                    ->schema([
                        Tabs::make('Mensajes')
                            ->tabs([
                                Tabs\Tab::make('Aprobación')
                                    ->icon('heroicon-m-check-circle')
                                    ->schema([
                                        Textarea::make('approval_message')
                                            ->label('Mensaje de Éxito')
                                            ->placeholder('¡Felicidades! Has aprobado esta etapa...')
                                            ->rows(4)
                                            ->autosize()
                                            ->helperText('Se envía automáticamente al aprobar la etapa.'),
                                    ]),

                                Tabs\Tab::make('Rechazo')
                                    ->icon('heroicon-m-x-circle')
                                    ->schema([
                                        Textarea::make('rejection_message')
                                            ->label('Mensaje de Rechazo')
                                            ->placeholder('Lo sentimos, no has cumplido con los requisitos...')
                                            ->rows(4)
                                            ->autosize()
                                            ->helperText('Se envía si el aplicante es descartado en esta etapa.'),
                                    ]),

                                Tabs\Tab::make('Evaluación')
                                    ->icon('heroicon-m-eye')
                                    ->schema([
                                        Textarea::make('requires_evaluatio_message')
                                            ->label('Mensaje de "En Revisión"')
                                            ->placeholder('Tu respuesta está siendo analizada por nuestro equipo...')
                                            ->rows(4)
                                            ->autosize()
                                            ->helperText('Se muestra cuando la IA no puede decidir y requiere ayuda humana.'),
                                    ]),
                            ]),
                    ]),

                Section::make('Cuestionario de la Etapa')
                    ->description('Añade, elimina y reordena las preguntas que conformarán esta etapa.')->icon('heroicon-m-question-mark-circle')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->label('Preguntas')
                            ->itemLabel(fn (array $state): ?string => Str::limit($state['question_text'] ?? 'Nueva Pregunta', 90))
                            ->collapsed()
                            ->cloneable()
                            ->schema([
                                Textarea::make('question_text')
                                    ->required()
                                    ->label('Texto de la Pregunta')
                                    ->rows(2)
                                    ->autosize(),
                            ])
                            ->orderColumn('order')
                            ->collapsible(),
                    ]),
            ]);
    }
}
