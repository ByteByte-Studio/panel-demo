<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
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
        $personType = $this->faker->randomElement(['persona_fisica', 'persona_moral']);
        $clientType = $this->faker->randomElement(['cliente', 'prospecto']);

        return [
            'full_name' => $personType === 'persona_moral' ? $this->faker->company() : $this->faker->name(),
            'person_type' => $personType,
            'client_type' => $clientType,
            'phone_number' => $this->faker->numerify('55########'),
            'email' => $this->faker->unique()->safeEmail(),
            'curp' => $personType === 'persona_fisica' ? strtoupper($this->faker->bothify('????######??????##')) : null,
            'rfc' => strtoupper($this->faker->bothify($personType === 'persona_fisica' ? '????######???' : '???######???')),
            'address' => $this->faker->streetAddress().', '.$this->faker->city().', '.$this->faker->state(),
            'occupation' => $personType === 'persona_fisica' ? $this->faker->jobTitle() : 'Empresa',
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
