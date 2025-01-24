<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function getByCustomer(int $customerId, array $relations = []): Collection;
    public function find(int $id, array $relations = []): ?Order;
    public function create(array $data): Order;
    public function update(Order $order, array $data): Order;
    public function delete(int $id): bool;
    public function getPaginated(int $perPage = 10, array $relations = []): LengthAwarePaginator;
    public function count(array $conditions): int;
    public function sum(string $column, array $conditions): float;
    public function getRecentOrdersPaginated(int $perPage = 10): LengthAwarePaginator;
    public function getRecentOrders(int $limit = 10): Collection;
    public function getMonthlySales(int $months = 12): Collection;
    public function getDailyOrdersCount(Carbon $date): int;
    public function getDailyRevenue(Carbon $date): float;
    public function getDailyOrders(Carbon $date): Collection;
}
