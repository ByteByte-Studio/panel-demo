<?php

namespace Database\Factories;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
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
        $status = $this->faker->randomElement(PaymentStatus::cases());

        return [
            'client_id' => Client::factory(),
            'amount' => $this->faker->randomFloat(2, 500, 25000),
            'payment_method' => $this->faker->randomElement(['Transferencia', 'Efectivo', 'Tarjeta de Crédito', 'Tarjeta de Débito']),
            'concept' => $this->faker->randomElement([
                'Pago de mensualidad',
                'Inscripción al curso',
                'Compra de material',
                'Abono a capital',
                'Liquidación de deuda',
            ]),
            'transaction_reference' => strtoupper($this->faker->bothify('TRX-####-????')),
            'paymentable_id' => function (array $attributes) {
                return $attributes['client_id'];
            },
            'paymentable_type' => Client::class,
            'due_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'payment_status' => $status,
            'notification_status' => $this->faker->randomElement(PaymentNotificationStatus::cases()),
            'is_notification_enabled' => $this->faker->boolean(95),
        ];
    }
}
