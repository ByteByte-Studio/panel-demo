<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Models\Group;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group as ComponentsGroup;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $modelLabel = 'Grupo';

    protected static ?string $pluralModelLabel = 'Grupos';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                ComponentsGroup::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Detalles del Grupo')
                            ->description('Configuración principal de la logística y capacidad.')
                            ->icon('heroicon-m-clipboard-document-list')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Grupo')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ej: Entrevistas Turno Mañana')
                                    ->columnSpan(1),

                                DateTimePicker::make('date_time')
                                    ->label('Fecha de Entrevista')
                                    ->required()
                                    ->seconds(false)
                                    ->native(false)
                                    ->displayFormat('d/m/Y H:i')
                                    ->minutesStep(15),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('location')
                                            ->label('Dirección')
                                            ->placeholder('Av. Principal #123...')
                                            ->prefixIcon('heroicon-m-map-pin')
                                            ->columnSpan(1),
                                        TextInput::make('location_link')
                                            ->label('Link de Google Maps')
                                            ->url()
                                            ->placeholder('https://maps.google.com/...')
                                            ->prefixIcon('heroicon-m-link')
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Section::make('Instrucciones para Aplicantes')
                            ->collapsible()
                            ->schema([
                                Textarea::make('message')
                                    ->label('Mensaje de Bienvenida')
                                    ->rows(5)
                                    ->helperText('Este mensaje será enviado por WhatsApp al confirmar.'),
                            ]),
                    ]),

                ComponentsGroup::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Estado y Capacidad')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aceptar Registros')
                                    ->helperText('Activa o desactiva la visibilidad del grupo.')
                                    ->onColor('success')
                                    ->default(true),

                                TextInput::make('capacity')
                                    ->label('Capacidad Máxima')
                                    ->default(25)
                                    ->numeric()
                                    ->required()
                                    ->prefixIcon('heroicon-m-ticket')
                                    ->minValue(fn (Get $get) => $get('current_members_count') ?? 0),
                            ]),

                        Section::make('Datos')
                            ->description('Información del sistema')
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Creado')
                                    ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? '-'),

                                TextInput::make('current_members_count')
                                    ->label('Miembros Actuales')
                                    ->numeric()
                                    ->readOnly()
                                    ->columnSpan(5)
                                    ->disabled()
                                    ->prefixIcon('heroicon-m-users'),
                            ])->visible(fn ($record) => $record !== null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Grupo')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user-group'),

                TextColumn::make('current_members_count')
                    ->label('Ocupación')
                    ->sortable()
                    ->formatStateUsing(fn ($state, Group $record) => "{$state} / {$record->capacity}")
                    ->badge()
                    ->color(fn ($state, Group $record) => match (true) {
                        $state >= $record->capacity => 'danger',
                        $state >= ($record->capacity * 0.8) => 'warning',
                        default => 'success',
                    })
                    ->icon(fn ($state, Group $record) => $state >= $record->capacity ? 'heroicon-m-lock-closed' : 'heroicon-m-lock-open'),

                TextColumn::make('date_time')
                    ->label('Fecha de Entrevista')
                    ->dateTime('l d M, Y - h:i A')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days')
                    ->description(fn (Group $record) => ucfirst($record->date_time->locale('es')->diffForHumans())),

                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->onColor('success')
                    ->offColor('danger'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Creado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Actualizado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\ApplicantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('group.view_any') ?? false;
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can('group.view') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('group.create') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('group.update') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('group.delete') ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('group.delete') ?? false;
    }
}
