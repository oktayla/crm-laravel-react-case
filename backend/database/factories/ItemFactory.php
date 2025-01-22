<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 10);

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->unit_price,
        ];
    }

    public function forExistingProducts(): static
    {
        return $this->state(function (array $attributes) {
            $product = Product::query()->inRandomOrder()->first() ??
                Product::factory()->create();

            return [
                'product_id' => $product->id,
                'unit_price' => $product->unit_price,
            ];
        });
    }
}
