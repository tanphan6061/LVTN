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
            'created_at', 'updated_at', 'is_deleted'
        ];
        return collect($this->resource)->except($exceptions);
    }
}
