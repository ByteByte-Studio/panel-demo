<?php

namespace Database\Factories;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Payment::class;

    public function definition(): array
    {
        $paymentableType = $this->faker->randomElement([
            Client::class,
        ]);

        $paymentable = $paymentableType::factory()->create();

        return [
            "client_id" => $paymentable->client_id ?? Client::factory(),
            "amount" => $this->faker->randomFloat(2, 500, 50000),
            "payment_method" => $this->faker->randomElement(['Transferencia', 'Efectivo']), // Nombre corregido
            "concept" => $this->faker->sentence(),
            "transaction_reference" => $this->faker->bothify('TRX-######'),
            'paymentable_id' => $paymentable->id,
            'paymentable_type' => $paymentableType,
            'due_date' => now()->addDays(7),
            'payment_status' => PaymentStatus::Pending,
            'notification_status' => PaymentNotificationStatus::NotReminded,
            'is_notification_enabled' => true,
        ];
    }
}
