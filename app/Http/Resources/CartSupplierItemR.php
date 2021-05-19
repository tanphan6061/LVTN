<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartSupplierItemR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->except(['items']);
        $data['products'] = CartProductItemR::collection($this['items']);
        return $data;
    }
}
