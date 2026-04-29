<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Definición de la Pregunta')
                    ->description('Configura el contenido y la etapa a la que pertenece.')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->columns(1)
                    ->schema([
                        Select::make('stage_id')
                            ->relationship('stage', 'name')
                            ->required()
                            ->label('Etapa del Proceso')
                            ->prefixIcon('heroicon-m-rectangle-stack')
                            ->native(false),

                        Textarea::make('question_text')
                            ->required()
                            ->label('Pregunta')
                            ->placeholder('¿Cuál es tu ingreso mensual aproximado?')
                            ->rows(3)
                            ->autosize(),
                    ]),

                Section::make('Lógica de Evaluación (IA)')
                    ->description('Reglas automáticas para validar la respuesta del aplicante.')
                    ->icon('heroicon-m-cpu-chip')
                    ->collapsible()
                    ->schema([
                        Repeater::make('approval_criteria')
                            ->label('Reglas')
                            ->addActionLabel('Agregar nueva regla')
                            ->itemLabel('Regla')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('rule')
                                            ->label('Acción')
                                            ->options([
                                                'approve_if' => 'Aprobar automáticamente sí...',
                                                'reject_if' => 'Rechazar automáticamente sí...',
                                                'human_if' => 'Solicitar revisión humana sí...',
                                            ])
                                            ->prefixIcon('heroicon-m-play')
                                            ->required(),

                                        Select::make('operator')
                                            ->label('Condición')
                                            ->options([
                                                'Texto' => [
                                                    'is' => 'es igual a',
                                                    'is_not' => 'no es igual a',
                                                    'contains' => 'contiene la palabra',
                                                    'does_not_contain' => 'no contiene',
                                                    'is_empty' => 'está vacío',
                                                    'is_not_empty' => 'tiene contenido',
                                                ],
                                                'Números' => [
                                                    'is_equal_to' => '= igual a',
                                                    'is_greater_than' => '> mayor que',
                                                    'is_less_than' => '< menor que',
                                                    'is_greater_than_or_equal_to' => '>= mayor o igual',
                                                    'is_less_than_or_equal_to' => '<= menor o igual',
                                                    'between' => 'está entre rango',
                                                ],
                                            ])
                                            ->required()
                                            ->searchable()
                                            ->columnSpan(fn (Get $get) => in_array($get('operator'), ['is_empty', 'is_not_empty']) ? 2 : 1)
                                            ->live(),

                                        TextInput::make('value')
                                            ->label('Valor de Comparación')
                                            ->required()
                                            ->placeholder('Valor...')
                                            ->hidden(fn (Get $get) => in_array($get('operator'), ['is_empty', 'is_not_empty'])),
                                    ]),
                            ])
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
