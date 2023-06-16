<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'smallDescription' => $this->small_description,
            'createdAt' => $this->created_at?->format('Y-m-d, H:i'),
            'updatedAt' => $this->updated_at?->format('Y-m-d, H:i'),
            'owner' => $this->user->fullName,
            'ownerId' => $this->user_id,

        ];
    }
}
