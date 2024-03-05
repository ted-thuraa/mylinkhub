<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'orderitem_id' => $this->orderitem_id,
            'order_status' => $this->order_status,
            'customer_id' => $this->customer_id,
            'user_email' => $this->user_email,
            'checkout_email' => $this->checkout_email,
            'planname' => $this->planname,
            'total_formatted' => $this->total_formatted,
            'total_price' => $this->total_price,
            'product_id' => $this->product_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
