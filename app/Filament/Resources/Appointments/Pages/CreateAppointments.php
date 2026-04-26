<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
use App\Models\Client;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateAppointments extends CreateRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($this->data['appointment_mode'] ?? null) === 'prospect') {

            return DB::transaction(function () use ($data) {
                $client = Client::create([
                    'full_name'    => $this->data['prospect_full_name'],
                    'phone_number' => $this->data['prospect_phone'] ?? '',
                    'email'        => $this->data['prospect_email'] ?? null,
                    'client_type'  => 'prospecto',
                    'person_type'  => 'persona_fisica',
                ]);

                $data['appointmentable_id']   = $client->id;
                $data['appointmentable_type'] = Client::class;

                return $data;
            });
        }

        if (($this->data['appointment_mode'] ?? null) === 'client') {
            $data['appointmentable_type'] = Client::class;
        }

        return $data;
    }
}
