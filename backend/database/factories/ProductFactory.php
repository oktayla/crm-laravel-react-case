<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => Str::title(fake()->words(asText: true)),
            'description' => fake()->paragraphs(2, true),
            'unit_price' => fake()->randomFloat(2, 10, 999),
            'stock' => fake()->numberBetween(100, 200),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
            'is_active' => false,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
