<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PopulateDataSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory(100)->create();

        Product::factory(100)->create();

        Order::factory(50)
            ->withItems(3)
            ->create();

        Order::factory(10)
            ->completed()
            ->create();

        Item::factory()
            ->forExistingProducts()
            ->count(5)
            ->create();
    }
}
