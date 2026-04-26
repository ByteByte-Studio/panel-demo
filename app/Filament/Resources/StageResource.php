<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StageResource\Pages;
use App\Models\Stage;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StageResource extends Resource
{
    protected static ?string $model = Stage::class;

    protected static ?string $modelLabel = 'Etapa';

    protected static ?string $pluralModelLabel = 'Etapas';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->paginated([25, 50, 100])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('name')
                    ->label('Nombre de la Etapa')
                    ->searchable(),

                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Preguntas')
                    ->badge()
                    ->color(fn (string $state): string => $state > 0 ? 'primary' : 'gray'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStages::route('/'),
            'create' => Pages\CreateStage::route('/create'),
            'edit' => Pages\EditStage::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('stage.view_any');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can('stage.view') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('stage.create') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('stage.update') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('stage.delete') ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('stage.delete') ?? false;
    }
}
