<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TempProductOrderDetailR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = [
            'category_id',
            'brand_id',
            'supplier_id',
            'is_deleted'
        ];

        $data = collect($this->resource)->except($exceptions);
        $data['grand_total'] = $this->grandTotal;
        $data['category'] = new CategoryOverviewR($this->category);
        $data['supplier'] = new SupplierR($this->supplier);
        $data['brand'] = new BrandR($this->brand);
        $data['images'] = ProductImageR::collection($this->images);
        return $data;
    }
}
