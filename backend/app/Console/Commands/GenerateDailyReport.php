<?php

namespace App\Console\Commands;

use App\Mail\DailyReportMail;
use App\Models\User;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateDailyReport extends Command
{
    protected $signature = 'app:generate-daily-report';

    protected $description = 'Generate comprehensive daily business report';

    public function handle(
        CustomerRepositoryInterface $customerRepository,
        OrderRepositoryInterface $orderRepository,
    ): int
    {
        $reportDate = today();

        try {
            $newCustomersCount = $customerRepository->getNewCustomersCount($reportDate);
            $totalOrders = $orderRepository->getDailyOrdersCount($reportDate);
            $totalRevenue = $orderRepository->getDailyRevenue($reportDate);
            $averageOrderValue = $totalOrders > 0
                ? $totalRevenue / $totalOrders
                : 0;

            $reportData = [
                'date' => $reportDate->toDateString(),
                'new_customers' => $newCustomersCount,
                'total_orders' => $totalOrders,
                'total_revenue' => round($totalRevenue, 2),
                'average_order_value' => round($averageOrderValue, 2),
            ];

            $this->sendReportEmail($reportData);

            $this->info('Daily report generated successfully.');
            return self::SUCCESS;
        } catch (Exception $e) {
            Log::error('Daily report generation failed', [
                'date' => $reportDate->toDateString(),
                'error' => $e->getMessage(),
            ]);

            return self::FAILURE;
        }
    }

    public function sendReportEmail(array $reportData): void
    {
        Mail::to($this->getAdmins())
            ->send(new DailyReportMail(today(), $reportData));
    }

    public function getAdmins(): array
    {
        return User::role('administrator')
            ->pluck('email')
            ->toArray();
    }
}
