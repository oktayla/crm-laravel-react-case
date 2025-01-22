<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'canceled']),
            'total_amount' => 0,
            'note' => fake()->optional(0.3)->sentence(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            $items = ItemFactory::new()
                ->count(fake()->numberBetween(1, 5))
                ->create(['order_id' => $order->id]);

            $order->update([
                'total_amount' => $items->sum('subtotal')
            ]);
        });
    }

    public function canceled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'canceled',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function withItems(int $count): static
    {
        return $this->afterCreating(function (Order $order) use ($count) {
            ItemFactory::new()
                ->count($count)
                ->create(['order_id' => $order->id]);

            $order->refresh();
            $order->update([
                'total_amount' => $order->items->sum('subtotal')
            ]);
        });
    }
}
