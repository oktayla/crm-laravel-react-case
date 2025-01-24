<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // Determine the type of activity based on the resource
        return match(true) {
            $this->resource instanceof Order => $this->formatOrderActivity(),
            $this->resource instanceof Customer => $this->formatCustomerActivity(),
            default => $this->formatGenericActivity()
        };
    }

    /**
     * Format Order activity
     *
     * @return array
     */
    protected function formatOrderActivity(): array
    {
        return [
            'type' => 'order',
            'id' => $this->id,
            'total_amount' => number_format($this->total_amount, 2),
            'status' => $this->status,
            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->full_name,
            ],
            'created_at' => $this->created_at?->diffForHumans(),
            'timestamp' => $this->created_at?->getTimestamp(),
        ];
    }

    /**
     * Format Customer activity
     *
     * @return array
     */
    protected function formatCustomerActivity(): array
    {
        return [
            'type' => 'customer',
            'id' => $this->id,
            'name' => $this->full_name,
            'email' => $this->email,
            'registration_date' => $this->created_at?->diffForHumans(),
            'total_orders' => $this->orders_count ?? 0,
            'timestamp' => $this->created_at?->getTimestamp(),
        ];
    }

    /**
     * Fallback method for generic activity formatting
     *
     * @return array
     */
    protected function formatGenericActivity(): array
    {
        return [
            'type' => 'generic',
            'id' => $this->id ?? null,
            'name' => $this->name ?? $this->title ?? null,
            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }

    /**
     * Create a collection of resources
     *
     * @param mixed $resource
     * @return AnonymousResourceCollection
     */
    public static function collection($resource): AnonymousResourceCollection
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'total' => $resource->count(),
                'timestamp' => now()->toDateTimeString(),
            ]
        ]);
    }
}
