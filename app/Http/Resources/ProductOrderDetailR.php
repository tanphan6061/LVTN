<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderDetailR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $acceptFields = ['quantity', 'price', 'discount'];
        $ext_data = collect($this->resource)->only($acceptFields);
        $data = collect($this->product)->except(['category_id', 'brand_id', 'supplier_id', 'discount', 'price'])->merge($ext_data);
        $data['grand_total'] = $this->price * (100 - $this->discount) / 100;
        $data['category'] = new CategoryR($this->product->category);
        $data['supplier'] = new SupplierR($this->product->supplier);
        $data['brand'] = new BrandR($this->product->brand);
        $data['images'] = ProductImageR::collection($this->product->images);

        return $data;
    }
}
