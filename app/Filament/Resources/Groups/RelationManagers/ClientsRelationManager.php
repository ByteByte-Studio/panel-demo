<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use App\Filament\Resources\Clients\ClientsResource;
use App\Models\Client;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'clients';

    protected static ?string $title = 'Miembros del Grupo';

    protected static string|BackedEnum|null $icon = 'heroicon-m-users';

    public function table(Table $table): Table
    {
        $columns = [
            TextColumn::make('full_name')
                ->label('Nombre')
                ->searchable(),

            TextColumn::make('phone_number')
                ->label('Número de Telefono')
                ->icon('heroicon-m-chat-bubble-left-right')
                ->searchable()
                ->formatStateUsing(function ($state) {
                    if (! $state) {
                        return '-';
                    }

                    return str_starts_with($state, '521') ? substr($state, 3) : $state;
                })
                ->url(fn ($state) => 'https://wa.me/'.$state)
                ->openUrlInNewTab(),

            TextColumn::make('curp')
                ->label('CURP')
                ->fontFamily(FontFamily::Mono)
                ->formatStateUsing(fn (string $state) => strtoupper($state))
                ->color('gray')
                ->searchable()
                ->toggleable(),
        ];

        array_push($columns,
            TextColumn::make('created_at')
                ->label('Fecha de Registro')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->label('Última Actualización')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        );

        return $table
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc')
            ->columns($columns)
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('assignClient')
                    ->label('Agregar Miembro')
                    ->icon('heroicon-m-user-plus')
                    ->color('primary')
                    ->schema([
                        Select::make('client_id')
                            ->label('Seleccionar Cliente')
                            ->helperText('Solo se muestran clientes sin grupo asignado.')
                            ->options(fn () => Client::whereNull('group_id')
                                ->whereNotNull('full_name')
                                ->orderBy('full_name')
                                ->pluck('full_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $group = $this->getOwnerRecord();

                        if ($group->clients()->count() >= $group->capacity) {
                            Notification::make()
                                ->title('Grupo Lleno')
                                ->body("Este grupo ya alcanzó su capacidad máxima de {$group->capacity} miembros.")
                                ->danger()
                                ->send();

                            return;
                        }

                        $client = Client::find($data['client_id']);
                        $client->update(['group_id' => $group->id]);

                        Notification::make()
                            ->title('Miembro Agregado')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                ActionGroup::make([

                    EditAction::make()
                        ->label('Editar')
                        ->url(fn ($record) => ClientsResource::getUrl('edit', ['record' => $record]))
                        ->openUrlInNewTab(),

                    Action::make('removeFromGroup')
                        ->label('Quitar del Grupo')
                        ->icon('heroicon-m-arrow-right-on-rectangle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Remover miembro')
                        ->modalDescription('El cliente dejará de pertenecer a este grupo, pero su ficha no será eliminada.')
                        ->action(fn (Client $record) => $record->update(['group_id' => null])),

                    DeleteAction::make()
                        ->label('Eliminar Definitivamente'),
                ])
                    ->color('gray'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkRemove')
                        ->label('Quitar seleccionados')
                        ->icon('heroicon-m-arrow-right-on-rectangle')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['group_id' => null])),
                ]),
            ])
            ->emptyStateHeading('Sin miembros asignados')
            ->emptyStateDescription('Utiliza el botón "Agregar Miembro" para comenzar a llenar este grupo.')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
