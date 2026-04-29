<?php

namespace Database\Factories;

use App\Models\InternalAnnouncement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternalAnnouncementFactory extends Factory
{
    protected $model = InternalAnnouncement::class;

    public function definition(): array
    {
        $titles = [
            'Nueva política de vacaciones',
            'Capacitación obligatoria: Seguridad de Datos',
            'Evento de integración - Fin de mes',
            'Actualización del Manual de Operaciones',
            'Bienvenida a los nuevos integrantes',
            'Mantenimiento programado del sistema',
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'body' => $this->faker->paragraphs(3, true),
            'created_by' => User::factory(),
        ];
    }
}
