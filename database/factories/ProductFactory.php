<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $name = fake()->words(3, true);
        return [
            'name' => $name,
            'description' => fake()->sentence,
            'body'        => fake()->paragraphs(3, true),
            'price'       => fake()->randomFloat(2, 10, 3000) * 100,
            'in_stock'    => rand(30, 1000),
            'slug'        => str($name)->slug(),
            'is_active'   => rand(0, 1)
        ];
    }
}
