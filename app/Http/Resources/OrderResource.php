<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'total'      => (float) $this->total,
            'status'     => $this->status,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // بما إن العلاقة One-to-Many، نعرض المنتجات لو متحمّلة (lazy-safe)
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];

    }
}