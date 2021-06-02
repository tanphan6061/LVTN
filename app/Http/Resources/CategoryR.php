<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryR extends JsonResource
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
            'created_at', 'updated_at', 'is_deleted', 'parent_category_id'
        ];
        $data = collect($this->resource)->except($exceptions);
        $data['parent'] = new CategoryOverviewR($this->parent_category);
        $data['childs'] = CategoryR::collection($this->childs);
        return $data;
    }
}
