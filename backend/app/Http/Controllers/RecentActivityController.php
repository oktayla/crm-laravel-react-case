<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecentActivityResource;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;

class RecentActivityController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $orderRepository,
        public CustomerRepositoryInterface $customerRepository,
        public ItemRepositoryInterface $itemRepository,
    ) {}

    /**
     * Get comprehensive recent activity dashboard
     *
     * @return JsonResponse
     */
    public function getDashboardActivity(): JsonResponse
    {
        $recentOrders = $this->orderRepository->getRecentOrders(5);
        $recentCustomers = $this->customerRepository->getRecentCustomers(5);

        return response()->json([
            'recent_orders' => RecentActivityResource::collection($recentOrders),
            'recent_customers' => RecentActivityResource::collection($recentCustomers),
        ]);
    }
}
