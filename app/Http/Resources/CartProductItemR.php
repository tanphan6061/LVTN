<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductItemR extends JsonResource
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
        $accepts = ['id', 'name', 'slug', 'price',
            'discount', 'quantity', 'amount','max_buy',
            'status', 'created_at', 'updated_at'];
        $data = collect($this->resource)->only($accepts);
        $data['available'] = $this->available;
        $data['grand_total'] = $this->grandTotal;
        $data['favourited'] = $this->favourited;
        $data['reviewed'] = $this->reviewed;
        $data['category'] = new CategoryR($this->category);
//        $data['supplier'] = new SupplierR($this->supplier);
        $data['brand'] = new BrandR($this->brand);
        $data['images'] = ProductImageR::collection($this->images);
        return $data;
    }
}
