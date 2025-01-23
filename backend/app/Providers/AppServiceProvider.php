<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Observers\ItemObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();

        Relation::morphMap([
            'user' => User::class,
            'customer' => Customer::class,
            'order' => Order::class,
            'product' => Product::class,
            'item' => Item::class,
        ]);

        Item::observe(ItemObserver::class);
    }
}
