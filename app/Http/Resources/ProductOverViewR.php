<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOverViewR extends JsonResource
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
            'category_id',
            'brand_id',
            'supplier_id',
            'is_deleted',
            'description',
        ];

        $data = collect($this->resource)->except($exceptions);
        $data['grand_total'] = $this->grandTotal;
        $data['images'] = ProductImageR::collection($this->images->take(1));
        $data['ratings'] = [
            'rating_average' => $this->reviews()->avg('star'),
            'rating_count' => $this->reviews()->count(),
            //'stars' => $this->stars,
        ];
        return $data;
    }
}
