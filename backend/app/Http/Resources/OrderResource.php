<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'note' => $this->note,
            //'customer' => CustomerResource::make($this->customer),
            'items' => ItemResource::collection($this->items),
        ];
    }
}
