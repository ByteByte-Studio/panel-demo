<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointments;
use App\Models\Client;
use App\Models\ClientCase;
use App\Models\User;
use App\Enums\AppointmentStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments>
 */
class AppointmentsFactory extends Factory
{
    protected $model = Appointments::class;

    public function definition(): array
    {
        return [
            "date_time" => fake()->dateTimeBetween('now', '+1 year'),
            "reason" => fake()->sentence(),
            "status" => fake()->randomElement(AppointmentStatus::toArray()),
            "modality" => fake()->randomElement(["Presencial", "Online", "Llamada"]),
            "notes" => fake()->paragraph(),
            'appointmentable_id' => Client::inRandomOrder()->value('id'),
            'appointmentable_type' => Client::class,
        ];
    }
}
