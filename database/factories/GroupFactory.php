<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [
            'Generación Primavera 2026',
            'Equipo de Ventas CDMX',
            'Desarrolladores Junior Q1',
            'Capacitación Atención al Cliente',
            'Entrevistas Administrativas',
            'Grupo de Apoyo Tecnológico',
            'Reclutamiento Masivo Enero',
        ];

        return [
            'name' => $this->faker->randomElement($names).' '.$this->faker->unique()->numberBetween(1, 100),
            'message' => $this->faker->paragraph(),
            'capacity' => $this->faker->numberBetween(10, 50),
            'date_time' => $this->faker->dateTimeBetween('now', '+6 months'),
            'location' => $this->faker->streetAddress().', '.$this->faker->city(),
            'location_link' => 'https://maps.google.com/?q='.$this->faker->latitude().','.$this->faker->longitude(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
