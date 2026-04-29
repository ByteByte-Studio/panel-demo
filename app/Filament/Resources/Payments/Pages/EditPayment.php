<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\ClientCase;
use App\Models\Procedure;
use App\Models\RecurrentPayment;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $type = $data['paymentable_type'] ?? null;
        $id = $data['paymentable_id'] ?? null;

        if ($type && $id) {
            $data['paymentable_selector'] = match ($type) {
                ClientCase::class => 'case',
                Procedure::class => 'procedure',
                RecurrentPayment::class => 'recurrent',
                default => null,
            };

            match ($data['paymentable_selector']) {
                'case' => $data['case_id'] = $id,
                'procedure' => $data['procedure_id'] = $id,
                'recurrent' => $data['recurrent_id'] = $id,
                default => null,
            };
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $selector = $data['paymentable_selector'] ?? null;

        if ($selector) {
            $data['paymentable_type'] = match ($selector) {
                'case' => ClientCase::class,
                'procedure' => Procedure::class,
                'recurrent' => RecurrentPayment::class,
            };

            $data['paymentable_id'] = match ($selector) {
                'case' => $data['case_id'],
                'procedure' => $data['procedure_id'],
                'recurrent' => $data['recurrent_id'],
            };
        }

        unset(
            $data['paymentable_selector'],
            $data['case_id'],
            $data['procedure_id'],
            $data['recurrent_id']
        );

        return $data;
    }
}
