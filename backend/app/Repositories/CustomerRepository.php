<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected Builder $model;

    public function __construct()
    {
        $this->model = Customer::query();
    }

    public function all(array $relations = [], array $columns = ['*']): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 10, array $relations = [], array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function find(int $id, array $relations = []): Customer
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data): Customer
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Customer
    {
        $customer = $this->find($id);
        $customer->update($data);

        return $customer->fresh();
    }

    public function delete(int $id): bool
    {
        $customer = $this->find($id);
        return $customer->delete();
    }

    public function search(string $term, array $relations = []): LengthAwarePaginator
    {
        return $this->model
            ->with($relations)
            ->whereAny(['first_name', 'last_name', 'phone', 'email'], 'like', '%' . $term . '%')
            ->paginate();
    }

    public function findByIds(array $ids, array $relations = []): Collection
    {
        return $this->model
            ->with($relations)
            ->whereIntegerInRaw('id', $ids)
            ->get();
    }

    public function getWhere(array $conditions, array $relations = []): Collection
    {
        return $this->model->with($relations)->where($conditions)->get();
    }

    public function getWherePaginated(
        array $conditions,
        array $relations = [],
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $order = 'desc'
    ): LengthAwarePaginator
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
    }

    public function firstWhere(array $conditions, array $relations = []): ?Customer
    {
        return $this->model->with($relations)->where($conditions)->first();
    }

    public function count(array $conditions = []): int
    {
        return $this->model->where($conditions)->count();
    }
}
