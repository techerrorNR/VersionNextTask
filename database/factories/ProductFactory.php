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
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 10, 500),
            'quantity' => fake()->numberBetween(1, 5),
            'type' => fake()->randomElement(['flat', 'discount']),
            'discount' => function (array $attrs) {
                return $attrs['type'] === 'discount'
                    ? fake()->randomFloat(2, 1, 50)
                    : null;
            },
        ];
    }
}
