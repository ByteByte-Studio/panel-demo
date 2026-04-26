<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client; // Asegúrate de que el modelo esté importado

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $personTypes = ['persona_fisica', 'persona_moral'];
        $clientTypes = ['cliente', 'prospecto']; 
        $personType = $this->faker->randomElement($personTypes);
        
        return [
            "full_name" => $this->faker->name(),
            "person_type" => $personType, 
            "client_type" => $this->faker->randomElement($clientTypes),
            "phone_number" => $this->faker->numerify('##########'), 
            "email" => $this->faker->unique()->safeEmail(), 
            
            "curp" => strtoupper($this->faker->bothify('????????????######??')), 
            "rfc" => strtoupper($this->faker->bothify('????######???')), 

            "address" => $this->faker->address(),
            "occupation" => $personType === 'Física' ? $this->faker->jobTitle() : null, 
            "date_of_birth" => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
        ];
    }
}