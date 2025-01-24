<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Http\Resources\MetaResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getRecentOrdersPaginated();

        return ResponseBuilder::success(
            data: [
                'orders' => OrderResource::collection($orders),
                'meta' => MetaResource::make($orders),
            ],
        );
    }

    public function store(Request $request): Order
    {
        return $this->orderService->createOrder($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->findOrder($id);

        return ResponseBuilder::success(
            data: OrderResource::make($order),
        );
    }

    public function updateStatus(Order $order, Request $request): JsonResponse
    {
        $order = $this->orderService->updateOrderStatus($order, $request->status);

        return ResponseBuilder::success(
            data: OrderResource::make($order),
        );
    }

    public function customerOrders(int $customerId): JsonResponse
    {
        $orders = $this->orderService->getCustomerOrders($customerId);

        return ResponseBuilder::success(
            data: OrderResource::collection($orders),
        );
    }
}
