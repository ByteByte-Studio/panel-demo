<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $names = [
            'Identificación Oficial',
            'Comprobante de Domicilio',
            'CURP',
            'RFC',
            'Acta de Nacimiento',
            'Título Profesional',
            'Contrato de Servicios',
        ];

        return [
            'name' => $this->faker->randomElement($names).' - '.$this->faker->lastName().'.pdf',
            'file_path' => 'documents/'.Str::uuid().'.pdf',
            'documentable_id' => Client::factory(),
            'documentable_type' => Client::class,
        ];
    }
}
