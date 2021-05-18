<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryR extends JsonResource
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
            'created_at', 'updated_at', 'is_deleted', 'parent_category_id '
        ];
        return collect($this->resource)->except($exceptions);
    }
}
