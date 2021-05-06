<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = [
            'sub_category_id',
            'brand_id',
            'supplier_id',
            'is_deleted'
        ];

        $data = collect($this->resource)->except($exceptions);
        $data['sub_category'] = new SubCategoryR($this->sub_category);
        $data['supplier'] = new SupplierR($this->supplier);
        $data['images'] = ProductImageR::collection($this->images);
        return $data;
    }
}
