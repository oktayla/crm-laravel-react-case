<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    protected Builder $model;

    public function __construct()
    {
        $this->model = Order::query();
    }

    public function getByCustomer(
        int $customerId,
        array $relations = []
    ): Collection
    {
        return $this->model->with($relations)
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function find(
        int $id,
        array $relations = []
    ): ?Order
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order->fresh();
    }

    public function delete(int $id): bool
    {
        if ($order = $this->find($id)) {
            return $order->delete();
        }

        return false;
    }

    public function getPaginated(
        int $perPage = 10,
        array $relations = []
    ): LengthAwarePaginator
    {
        return $this->model->with($relations)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
