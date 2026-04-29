<?php

namespace Database\Factories;

use App\Models\InternalMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternalMessage>
 */
class InternalMessageFactory extends Factory
{
    protected $model = InternalMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Duda sobre expediente de cliente',
            'Seguimiento a pago pendiente',
            'Solicitud de apoyo técnico',
            'RE: Evento de integración',
            'Reporte semanal de actividades',
            'Aviso de ausencia por cita médica',
        ];

        return [
            'sender_id' => User::factory(),
            'subject' => $this->faker->randomElement($subjects),
            'body' => $this->faker->paragraphs(2, true),
        ];
    }
}
