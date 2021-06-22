<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = ['email', 'updated_at'];
        $accepts = ['id', 'slug', 'nameOfShop', 'avatar', 'created_at'];
        $data = collect($this->resource)->only($accepts);
        $data['ratings'] = [
            'rating_count' => $this->reviews->count(),
            'rating_average' => $this->reviews->avg('star')
        ];
        return $data;
    }
}
