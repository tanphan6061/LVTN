<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->except('user_id', 'product_id','is_deleted');
        $data['product'] = new ProductR($this->product);
        return $data;
    }
}
