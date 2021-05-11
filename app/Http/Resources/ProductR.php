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
        $data['category'] = new CategoryR($this->category);
        $data['supplier'] = new SupplierR($this->supplier);
        $data['brand'] = new BrandR($this->brand);
        $data['images'] = ProductImageR::collection($this->images);
        $data['rating_average'] = $this->reviews()->avg('star');
        $data['rating_count'] = $this->reviews()->count();
        return $data;
    }
}
