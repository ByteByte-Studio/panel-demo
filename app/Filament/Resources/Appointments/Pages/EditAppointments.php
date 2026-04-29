<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
//
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointments extends EditRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load('appointmentable');

        if ($record->appointmentable?->client_type === 'prospecto') {
            $data['appointment_mode'] = 'prospect';

            $data['prospect_full_name'] = $record->appointmentable->full_name;
            $data['prospect_phone'] = $record->appointmentable->phone_number;
            $data['prospect_email'] = $record->appointmentable->email;
        } else {
            $data['appointment_mode'] = 'client';
        }

        return $data;
    }
}
