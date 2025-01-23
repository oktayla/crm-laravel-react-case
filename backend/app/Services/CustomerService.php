<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function getPaginatedCustomers(
        int $perPage = 10,
        array $relations = [],
        array $filters = []
    ): LengthAwarePaginator
    {
        return $this->customerRepository
            ->getWherePaginated($filters, $relations, $perPage);
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
        string $term,
        array $relations = []
    ): LengthAwarePaginator
    {
        return $this->customerRepository->search($term, $relations);
    }

    public function getCustomerDetails(
        int $id,
        array $relations = []
    ): Customer
    {
        return $this->customerRepository->find($id, $relations);
    }
}
