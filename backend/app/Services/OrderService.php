<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function createOrder(array $data)
    {
        $customer = $this->customerRepository->find($data['customer_id']);
        if (!$customer) {
            return null;
        }

        if (!empty($data['items'])) {
            $data['total_amount'] = $this->calculateTotal($data['items']);
        }

        $data['status'] = 'pending';

        $order = $this->orderRepository->create($data);

        if (!empty($data['items'])) {
            $order->items()->createMany($data['items']);
        }
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        return $this->orderRepository->update($order, ['status' => $status]);
    }

    public function getCustomerOrders(int $customerId): Collection
    {
        return $this->orderRepository->getByCustomer($customerId, ['items']);
    }

    public function findOrder(int $id): ?Order
    {
        $order = $this->orderRepository->find($id, ['items', 'customer']);

        if (!$order) {
            return null;
        }

        return $order;
    }

    protected function calculateTotal(array $items): float
    {
        return collect($items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }
}
