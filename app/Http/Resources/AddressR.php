<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $accepts = ['id', 'name', 'phone', 'address', 'active'];
        return collect($this->resource)->only($accepts);
    }
}
