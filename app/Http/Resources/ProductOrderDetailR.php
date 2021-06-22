<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderDetailR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        $acceptFields = ['id', 'product_id', 'quantity', 'price', 'discount'];
        $ext_data = collect($this->resource)->only($acceptFields);
        return collect(json_decode($this->temp_product))->merge($ext_data)->merge(
            [
                'grand_total' => $this->price * (100 - $this->discount) / 100
            ]
        );
    }
}
