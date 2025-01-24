<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function count(array $conditions = []): int
    {
        return $this->model->where($conditions)->count();
    }

    public function sum(string $column, array $conditions = []): float
    {
        return $this->model->where($conditions)->sum($column);
    }

    public function getRecentOrders(int $limit = 10): Collection
    {
        return $this->model
            ->with('customer')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function getRecentOrdersPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('customer', 'items.product')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function getMonthlySales(int $months = 12): Collection
    {
        return $this->model
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take($months)
            ->get();
    }

    public function getDailyOrdersCount(Carbon $date): int
    {
        return $this->model->whereDate('created_at', $date)->count();
    }

    public function getDailyRevenue(Carbon $date): float
    {
        return $this->model
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    public function getDailyOrders(Carbon $date): Collection
    {
        return $this->model
            ->whereDate('created_at', $date)
            ->with(['customer', 'items'])
            ->get();
    }
}
