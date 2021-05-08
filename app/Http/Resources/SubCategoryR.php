<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryR extends JsonResource
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
            'created_at', 'updated_at', 'is_deleted', 'category_id'
        ];
        $data = collect($this->resource)->except($exceptions);
        $data['category_id'] = new CategoryR($this->category);
        return $data;
    }
}
