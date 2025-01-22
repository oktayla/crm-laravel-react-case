<?php

namespace App\Services;

use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Customer;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function getPaginatedCustomers(
        int $perPage = 10,
        array $relations = [],
        array $filters = []
    ): LengthAwarePaginator {
        if (!empty($filters)) {
            return $this->customerRepository
                ->getWhere($filters, $relations)
                ->paginate($perPage);
        }

        return $this->customerRepository->paginate($perPage, $relations);
    }

    public function createCustomer(array $data): Customer
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(int $id, array $data): Customer
    {
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer(int $id): bool
    {
        return $this->customerRepository->delete($id);
    }

    public function searchCustomers(
        array $criteria,
        array $relations = []
    ): Collection
    {
        return $this->customerRepository->search($criteria, $relations);
    }

    public function getCustomerDetails(
        int $id,
        array $relations = []
    ): Customer
    {
        return $this->customerRepository->find($id, $relations);
    }
}
