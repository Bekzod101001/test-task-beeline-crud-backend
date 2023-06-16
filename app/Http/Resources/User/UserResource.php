<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Product\IndexProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'surname' => $this->surname,
            'fullName' => $this->fullName,
            'username' => $this->username,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'products' => IndexProductResource::collection($this->products)
        ];
    }
}
