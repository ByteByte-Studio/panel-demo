<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = $this->faker->randomElement(['user', 'assistant']);

        $messages = [
            'user' => [
                'Hola, ¿cómo puedo aplicar para la vacante?',
                'Tengo una duda sobre los documentos.',
                '¿Cuándo es mi próxima entrevista?',
                'Gracias por la información.',
                '¿Cuál es el sueldo de la posición?',
                'Ya subí mis documentos, ¿qué sigue?',
            ],
            'assistant' => [
                'Hola, con gusto te ayudo. Por favor dime tu nombre.',
                'Puedes subir tus documentos en el portal del aplicante.',
                'Tu entrevista está programada para el próximo lunes.',
                'De nada, estamos para servirte.',
                'El sueldo depende de la experiencia, pero el rango es de $20k a $30k.',
                'Perfecto, nuestro equipo revisará tus documentos en las próximas 24 horas.',
            ],
        ];

        return [
            'conversation_id' => Conversation::factory(),
            'phone' => $this->faker->numerify('521##########'),
            'message' => $this->faker->randomElement($messages[$role]),
            'role' => $role,
            'name' => $this->faker->name(),
        ];
    }
}
