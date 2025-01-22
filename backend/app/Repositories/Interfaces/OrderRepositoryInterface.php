<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
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
}
