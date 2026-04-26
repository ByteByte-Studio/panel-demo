<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Storage;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos del Cliente';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Clasificación del Archivo')
                    ->icon('heroicon-m-tag')
                    ->schema([
                        Select::make('name')
                            ->label('Tipo de Documento')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-document-magnifying-glass')
                            ->options([
                                'Identidad' => [
                                    'acta_nacimiento' => 'Acta de nacimiento',
                                    'pasaporte' => 'Pasaporte',
                                    'curp' => 'CURP',
                                    'identificacion_oficial' => 'Identificación oficial (INE)',
                                ],
                                'Migración' => [
                                    'formato_i130' => 'Petición familiar (I-130)',
                                    'formato_i485' => 'Ajuste de estatus (I-485)',
                                    'formato_i765' => 'Permiso de trabajo (I-765)',
                                    'visa_turista' => 'Visa de turista',
                                ],
                                'Otros' => [
                                    'comprobante_domicilio' => 'Comprobante de domicilio',
                                    'antecedentes_penales' => 'Antecedentes penales',
                                    'otro' => 'Otro documento',
                                ],
                            ]),
                    ]),

                Section::make('Carga de Archivo')
                    ->icon('heroicon-m-cloud-arrow-up')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Documento Digitalizado')
                            ->required()
                            ->disk('public')
                            ->directory('documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->openable()
                            ->downloadable()
                            ->previewable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn($record) => Storage::disk('public')->url($record->file_path))
            ->openRecordUrlInNewTab()
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Documento')
                    ->searchable()
                    ->sortable()
                    ->icon(fn($record) => str_contains($record->file_path, '.pdf')
                        ? 'heroicon-s-document-text'
                        : 'heroicon-s-photo')
                    ->iconColor(fn($record) => str_contains($record->file_path, '.pdf') ? 'danger' : 'info')
                    ->formatStateUsing(fn(string $state): string => str($state)->replace('_', ' ')->title()),

                TextColumn::make('created_at')
                    ->label('Fecha de Carga')
                    ->date('d M, Y')
                    ->description(fn($record) => $record->created_at->diffForHumans())
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Cargar Documento')
                    ->icon('heroicon-m-plus-circle')
                    ->modalWidth('2xl'),
            ])
            ->recordActions([
                EditAction::make()->modalWidth('2xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
