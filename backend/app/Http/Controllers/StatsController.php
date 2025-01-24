<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $orderRepository,
        public CustomerRepositoryInterface $customerRepository,
        public ItemRepositoryInterface $itemRepository,
    ) {}

    public function show(): JsonResponse
    {
        return ResponseBuilder::success(
            data: Cache::remember('stats', now()->addHour(), function () {
                return [
                    'total_orders' => $this->orderRepository->count(),
                    'total_revenue' => $this->orderRepository->sum('total_amount'),
                    'total_sales' => $this->itemRepository->completedOrderQuantity(),
                    'total_customers' => $this->customerRepository->count(),
                    'sales_performance' => $this->salesPerformanceChart(),
                ];
            })
        );
    }

    public function salesPerformanceChart(): array
    {
        $monthlySales = $this->orderRepository->getMonthlySales();

        $labels = $monthlySales->pluck('month')->toArray();
        $salesData = $monthlySales->pluck('total_sales')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Monthly Sales',
                    'data' => $salesData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'fill' => true,
                ],
            ],
            'metadata' => [
                'total_sales' => array_sum($salesData),
                'average_monthly_sales' => round(array_sum($salesData) / count($salesData), 2),
            ],
        ];
    }
}
