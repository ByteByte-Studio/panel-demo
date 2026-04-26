<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Genera un nombre de archivo falso, ej: "recibo.pdf"
            'name' => $this->faker->word() . '.pdf', 
            // Genera una ruta falsa
            'file_path' => 'documents/' . Str::uuid() . '.pdf',
        ];
    }
}