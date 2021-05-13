<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->only(['id', 'name','created_at']);
        $data['rating_count'] = $this->reviews->count();
        return $data;
    }
}
