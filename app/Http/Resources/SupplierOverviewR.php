<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOverviewR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $accepts = ['id', 'slug', 'nameOfShop', 'avatar', 'created_at'];
        return collect($this->resource)->only($accepts);
    }
}
