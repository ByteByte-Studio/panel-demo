<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questions = [
            '¿Cuál es tu nivel de experiencia en Laravel?',
            '¿Tienes disponibilidad para viajar?',
            '¿Cuál es tu pretensión salarial mensual?',
            '¿Has trabajado antes con Filament v3?',
            '¿Cuál es tu nivel de inglés?',
            '¿En qué ciudad resides actualmente?',
            '¿Cuántos años de experiencia tienes en desarrollo web?',
            '¿Conoces los principios SOLID?',
        ];

        return [
            'stage_id' => Stage::factory(),
            'question_text' => $this->faker->randomElement($questions),
            'approval_criteria' => [
                'type' => 'text',
                'rule' => 'contains',
                'value' => 'sí',
            ],
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
