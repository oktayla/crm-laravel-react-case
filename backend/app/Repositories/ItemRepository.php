<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ItemRepository implements ItemRepositoryInterface
{
    protected Builder $model;

    public function __construct()
    {
        $this->model = Item::query();
    }

    public function completedOrderQuantity(): int
    {
        return $this->model
            ->whereRelation('order', 'status', 'completed')
            ->sum('quantity');
    }

    public function sum(string $column, array $conditions = []): float
    {
        return $this->model->where($conditions)->sum($column);
    }
}
