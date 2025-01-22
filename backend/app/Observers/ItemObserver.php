<?php

namespace App\Observers;

use App\Models\Item;

class ItemObserver
{
    public function saving(Item $item): void
    {
        $item->subtotal = $item->quantity * $item->unit_price;
    }
}
