<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\ClientCase;
use App\Models\Procedure;
use App\Models\RecurrentPayment;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $selector = $data['paymentable_selector'] ?? null;

        $data['paymentable_type'] = match ($selector) {
            'case' => ClientCase::class,
            'procedure' => Procedure::class,
            'recurrent' => RecurrentPayment::class,
            default => throw new \Exception('Debe seleccionar un destino válido para el pago.'),
        };

        $data['paymentable_id'] = match ($selector) {
            'case' => $data['case_id'],
            'procedure' => $data['procedure_id'],
            'recurrent' => $data['recurrent_id'],
        };

        unset(
            $data['paymentable_selector'],
            $data['case_id'],
            $data['procedure_id'],
            $data['recurrent_id']
        );

        return $data;
    }
}
