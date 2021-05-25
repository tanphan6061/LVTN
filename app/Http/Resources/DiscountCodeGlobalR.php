<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCodeGlobalR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = ['id','is_deleted', 'supplier_id', 'category_id'];
        $data = collect($this->resource)->except($exceptions);
        $data['category'] = new CategoryR($this->category);
        return $data;
    }
}
