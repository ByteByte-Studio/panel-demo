<?php

namespace Database\Factories;

use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Entrevista Inicial',
                'Examen Técnico',
                'Revisión de Documentación',
                'Entrevista con Manager',
                'Pruebas Psicométricas',
                'Verificación de Referencias',
                'Oferta Económica',
                'Contratación',
            ]),
            'order' => $this->faker->numberBetween(1, 100),
            'starting_message' => 'Bienvenido a la etapa de '.$this->faker->word.'. Por favor responde las siguientes preguntas.',
            'approval_message' => 'Felicidades, has aprobado esta etapa satisfactoriamente.',
            'rejection_message' => 'Lo sentimos, en este momento no podemos continuar con tu proceso en esta etapa.',
            'requires_evaluatio_message' => 'Tu respuesta ha sido recibida y será evaluada por nuestro equipo a la brevedad.',
        ];
    }
}
