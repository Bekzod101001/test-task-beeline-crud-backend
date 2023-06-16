<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request)
    {
        return [
            'total' => $this->total(),
            'last' => $this->lastPage(),
            'current' => $this->currentPage()
        ];

    }
}
