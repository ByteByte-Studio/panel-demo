<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            'Registro Inicial',
            'Validación de Documentos',
            'Entrevista Técnica',
            'Evaluación Psicométrica',
            'Oferta y Cierre',
        ];

        foreach ($stages as $index => $name) {
            $stage = Stage::factory()->create([
                'name' => $name,
                'order' => $index + 1,
            ]);

            Question::factory()->count(3)->create([
                'stage_id' => $stage->id,
            ]);
        }
    }
}
