<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResultR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        return [
            'products' => [
                'data' => ProductR::collection($resource->products->getData()),
                'total_count' => $resource->products->getTotal(),
            ],
            'filters' => [
                'brands' => [
                    'data' => BrandR::collection($resource->brands),
                    'total_count' => $resource->brands->count(),
                ],
                'suppliers' => [
                    'data' => SupplierR::collection($this->suppliers),
                    'total_count' => $this->suppliers->count(),
                ],

                'sort_settings' => [
                    'data' => $resource->sort_settings,
                    'total_count' => $resource->sort_settings->count()
                ]
            ],

        ];
    }
}
