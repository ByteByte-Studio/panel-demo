<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'sku' => $this->faker->unique()->bothify('PROD-####-????'),
            'images' => [
                'https://picsum.photos/seed/'.$this->faker->word.'/640/480',
                'https://picsum.photos/seed/'.$this->faker->word.'/640/480',
            ],
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
