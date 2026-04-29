<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointments;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointments>
 */
class AppointmentsFactory extends Factory
{
    protected $model = Appointments::class;

    public function definition(): array
    {
        $reasons = [
            'Entrevista de seguimiento',
            'Firma de contrato',
            'Entrega de documentación',
            'Asesoría técnica',
            'Revisión de expediente',
            'Cita de evaluación',
        ];

        return [
            'date_time' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'reason' => $this->faker->randomElement($reasons),
            'status' => $this->faker->randomElement(AppointmentStatus::cases()),
            'modality' => $this->faker->randomElement(['Presencial', 'Online (Zoom)', 'Llamada telefónica']),
            'notes' => $this->faker->optional()->paragraph(),
            'appointmentable_id' => Client::factory(),
            'appointmentable_type' => Client::class,
        ];
    }
}
