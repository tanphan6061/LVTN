<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCodeR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $accepts = ['code', 'start_date', 'end_date', 'percent', 'from_price', 'max_price'];
        return collect($this->resource)->only($accepts);
    }
}
