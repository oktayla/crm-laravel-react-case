<?php

namespace App\Repositories\Interfaces;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function all(array $relations = [], array $columns = ['*']): Collection;
    public function paginate(int $perPage = 10, array $relations = [], array $columns = ['*']): LengthAwarePaginator;
    public function find(int $id, array $relations = []): Customer;
    public function create(array $data): Customer;
    public function update(int $id, array $data): Customer;
    public function delete(int $id): bool;
    public function search(string $term, array $relations = []): LengthAwarePaginator;
    public function findByIds(array $ids, array $relations = []): Collection;
    public function getWhere(array $conditions, array $relations = []): Collection;
    public function firstWhere(array $conditions, array $relations = []): ?Customer;
    public function count(array $conditions = []): int;
    public function getRecentCustomers(int $limit = 10): Collection;
}
